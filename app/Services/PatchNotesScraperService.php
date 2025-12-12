<?php

namespace App\Services;

use App\Models\PatchNote;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Scrapes patch notes from various game sources
 */
class PatchNotesScraperService
{
    /**
     * CSS selectors for finding patch note content in HTML
     */
    protected const HTML_SELECTORS = 'article[class*="patch"], div[class*="patch"], article[class*="update"], div[class*="update"], .post, article';
    
    /**
     * Maximum number of items to scrape per game
     */
    protected const MAX_ITEMS_PER_SCRAPE = 10;

    /**
     * Scrape patch notes for all configured games
     */
    public function scrapeAll(): array
    {
        $results = [];
        
        $games = [
            'Counter Strike 2' => 'https://www.counter-strike.net/newsentry/',
            'GTA V' => 'https://www.rockstargames.com/newswire/tags/702',
            'Fortnite' => 'https://www.fortnite.com/news',
            'Call of Duty' => 'https://www.callofduty.com/blog',
            'Valorant' => 'https://playvalorant.com/en-us/news/game-updates/',
            'Apex Legends' => 'https://www.ea.com/games/apex-legends/news',
            'League of Legends' => 'https://www.leagueoflegends.com/en-us/news/game-updates/',
            'Dota 2' => 'https://www.dota2.com/patches/',
        ];

        foreach ($games as $gameName => $baseUrl) {
            try {
                $count = $this->scrapeGame($gameName, $baseUrl);
                $results[$gameName] = $count;
                Log::info("Scraped {$count} patch notes for {$gameName}");
            } catch (\Exception $e) {
                $results[$gameName] = 0;
                Log::error("Failed to scrape patch notes for {$gameName}: {$e->getMessage()}");
            }
        }

        return $results;
    }

    /**
     * Scrape patch notes for a specific game
     */
    protected function scrapeGame(string $gameName, string $baseUrl): int
    {
        $count = 0;

        // For this implementation, we'll use a generic RSS/Atom feed approach
        // In a production environment, you'd implement specific scrapers for each game
        
        try {
            // Try to fetch RSS feed if available
            $rssUrl = $this->guessRssFeedUrl($baseUrl);
            if ($rssUrl) {
                $count = $this->scrapeFromRss($gameName, $rssUrl);
            }
            
            // If RSS doesn't work, try HTML scraping
            if ($count === 0) {
                $count = $this->scrapeFromHtml($gameName, $baseUrl);
            }
        } catch (\Exception $e) {
            Log::warning("Could not scrape {$gameName}: {$e->getMessage()}");
        }

        return $count;
    }

    /**
     * Attempt to guess RSS feed URL from base URL
     */
    protected function guessRssFeedUrl(string $baseUrl): ?string
    {
        $possibleFeeds = [
            $baseUrl . '/feed',
            $baseUrl . '/rss',
            $baseUrl . '/atom',
            str_replace('news/', 'news/feed/', $baseUrl),
        ];

        foreach ($possibleFeeds as $feedUrl) {
            try {
                $response = Http::timeout(5)->get($feedUrl);
                if ($response->successful() && 
                    (str_contains($response->body(), '<rss') || str_contains($response->body(), '<feed'))) {
                    return $feedUrl;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Scrape patch notes from RSS/Atom feed
     */
    protected function scrapeFromRss(string $gameName, string $rssUrl): int
    {
        $count = 0;

        try {
            $response = Http::timeout(10)->get($rssUrl);
            if (!$response->successful()) {
                return 0;
            }

            $xml = simplexml_load_string($response->body());
            if (!$xml) {
                return 0;
            }

            // Handle RSS 2.0
            if (isset($xml->channel->item)) {
                foreach ($xml->channel->item as $item) {
                    if ($this->isPatchNoteItem((string)$item->title, (string)($item->description ?? ''))) {
                        $this->storePatchNote($gameName, [
                            'title' => (string)$item->title,
                            'description' => strip_tags((string)($item->description ?? '')),
                            'content' => (string)($item->description ?? $item->content ?? ''),
                            'source_url' => (string)$item->link,
                            'released_at' => isset($item->pubDate) ? date('Y-m-d H:i:s', strtotime((string)$item->pubDate)) : now(),
                            'external_id' => md5((string)$item->link),
                        ]);
                        $count++;
                    }
                }
            }
            
            // Handle Atom
            if (isset($xml->entry)) {
                foreach ($xml->entry as $entry) {
                    if ($this->isPatchNoteItem((string)$entry->title, (string)($entry->summary ?? ''))) {
                        $this->storePatchNote($gameName, [
                            'title' => (string)$entry->title,
                            'description' => strip_tags((string)($entry->summary ?? '')),
                            'content' => (string)($entry->content ?? $entry->summary ?? ''),
                            'source_url' => (string)$entry->link['href'] ?? '',
                            'released_at' => isset($entry->published) ? date('Y-m-d H:i:s', strtotime((string)$entry->published)) : now(),
                            'external_id' => md5((string)($entry->link['href'] ?? $entry->id)),
                        ]);
                        $count++;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning("RSS scraping failed for {$gameName}: {$e->getMessage()}");
        }

        return $count;
    }

    /**
     * Scrape patch notes from HTML page
     */
    protected function scrapeFromHtml(string $gameName, string $url): int
    {
        $count = 0;

        try {
            $response = Http::timeout(10)->get($url);
            if (!$response->successful()) {
                return 0;
            }

            $crawler = new Crawler($response->body());
            
            // Look for common patch note patterns in HTML - combine selectors for efficiency
            try {
                $crawler->filter(self::HTML_SELECTORS)->each(function (Crawler $node) use ($gameName, &$count) {
                    // Limit to reasonable amount to avoid processing too many items
                    if ($count >= self::MAX_ITEMS_PER_SCRAPE) {
                        return;
                    }
                    
                    $title = $this->extractTitle($node);
                    $content = $this->extractContent($node);
                    $link = $this->extractLink($node);

                    if ($title && $this->isPatchNoteItem($title, $content)) {
                        $this->storePatchNote($gameName, [
                            'title' => $title,
                            'description' => Str::limit(strip_tags($content), 200),
                            'content' => $content,
                            'source_url' => $link,
                            'released_at' => now(),
                            'external_id' => md5($link ?: $title),
                        ]);
                        $count++;
                    }
                });
            } catch (\Exception $e) {
                Log::warning("HTML selector parsing failed for {$gameName}: {$e->getMessage()}");
            }
        } catch (\Exception $e) {
            Log::warning("HTML scraping failed for {$gameName}: {$e->getMessage()}");
        }

        return $count;
    }

    /**
     * Check if item is likely a patch note based on title/content
     */
    protected function isPatchNoteItem(string $title, string $content): bool
    {
        $keywords = [
            'patch', 'update', 'notes', 'changelog', 'hotfix', 
            'version', 'release', 'bug fix', 'balance', 'changes'
        ];

        $text = strtolower($title . ' ' . $content);
        
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract title from HTML node
     */
    protected function extractTitle(Crawler $node): ?string
    {
        try {
            // Try different title selectors
            $selectors = ['h1', 'h2', 'h3', '.title', '.headline', 'header'];
            
            foreach ($selectors as $selector) {
                $title = $node->filter($selector)->first();
                if ($title->count() > 0) {
                    return trim($title->text());
                }
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return null;
    }

    /**
     * Extract content from HTML node
     */
    protected function extractContent(Crawler $node): string
    {
        try {
            // Try different content selectors
            $selectors = ['.content', '.body', '.description', 'p'];
            
            foreach ($selectors as $selector) {
                $content = $node->filter($selector);
                if ($content->count() > 0) {
                    return trim($content->html());
                }
            }

            // Fallback to full node HTML
            return trim($node->html());
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Extract link from HTML node
     */
    protected function extractLink(Crawler $node): ?string
    {
        try {
            $link = $node->filter('a')->first();
            if ($link->count() > 0) {
                return $link->attr('href');
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return null;
    }

    /**
     * Store or update patch note in database
     */
    protected function storePatchNote(string $gameName, array $data): void
    {
        // Check if already exists by external_id
        if (isset($data['external_id'])) {
            $existing = PatchNote::where('external_id', $data['external_id'])->first();
            if ($existing) {
                return; // Already exists, skip
            }
        }

        // Extract version from title if present
        $version = $this->extractVersion($data['title']);

        PatchNote::create([
            'game_name' => $gameName,
            'version' => $version,
            'title' => $data['title'],
            'description' => Str::limit($data['description'] ?? strip_tags($data['content']), 500),
            'content' => $data['content'],
            'source_url' => $data['source_url'] ?? null,
            'external_id' => $data['external_id'] ?? null,
            'released_at' => $data['released_at'] ?? now(),
            'is_published' => true,
            'is_featured' => false,
        ]);
    }

    /**
     * Extract version number from title
     */
    protected function extractVersion(string $title): ?string
    {
        // Match patterns like "v1.2.3", "1.2.3", "Season 5", "Update 2.1"
        if (preg_match('/v?(\d+\.\d+\.?\d*)/i', $title, $matches)) {
            return $matches[1];
        }

        if (preg_match('/Season\s+(\d+)/i', $title, $matches)) {
            return 'Season ' . $matches[1];
        }

        if (preg_match('/Update\s+(\d+\.?\d*)/i', $title, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
