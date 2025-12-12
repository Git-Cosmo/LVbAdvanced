<?php

namespace App\Services;

use App\Models\News;
use App\Models\RssFeed;
use App\Models\RssImportedItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RssFeedService
{
    /**
     * Fetch and import items from an RSS feed.
     */
    public function importFeed(RssFeed $feed): array
    {
        $results = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        try {
            $items = $this->fetchFeedItems($feed);

            foreach ($items as $item) {
                try {
                    $guid = $this->getElementText($item, 'guid') ?: $this->getElementText($item, 'link');
                    $guid = $guid ?: sha1($this->getElementText($item, 'title').$this->getElementText($item, 'pubDate'));

                    // Check if already imported
                    if (RssImportedItem::where('guid', $guid)->where('rss_feed_id', $feed->id)->exists()) {
                        $results['skipped']++;

                        continue;
                    }

                    // Create news article
                    $news = $this->createNewsFromItem($feed, $item);

                    // Track import
                    RssImportedItem::create([
                        'rss_feed_id' => $feed->id,
                        'guid' => $guid,
                        'news_id' => $news->id,
                    ]);

                    $results['success']++;
                    $results['messages'][] = "Imported: {$news->title}";
                } catch (\Exception $e) {
                    $results['errors']++;
                    $results['messages'][] = "Error importing item: {$e->getMessage()}";
                    Log::error('RSS import item error', [
                        'feed_id' => $feed->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            // Update last fetched time
            $feed->update(['last_fetched_at' => now()]);

        } catch (\Exception $e) {
            $results['errors']++;
            $results['messages'][] = "Feed error: {$e->getMessage()}";
            Log::error('RSS import feed error', [
                'feed_id' => $feed->id,
                'error' => $e->getMessage(),
            ]);
        }

        return $results;
    }

    /**
     * Fetch raw items using Laravel HTTP and SimpleXML.
     */
    protected function fetchFeedItems(RssFeed $feed): array
    {
        $response = Http::timeout(30)
            ->withHeaders(['User-Agent' => 'LVbAdvanced RSS Importer'])
            ->get($feed->url);

        if ($response->failed()) {
            throw new \Exception(sprintf('HTTP %s fetching %s', $response->status(), $feed->url));
        }

        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response->body(), \SimpleXMLElement::class, LIBXML_NOCDATA);

        if (! $xml) {
            $errors = libxml_get_errors();
            $messages = array_map(fn ($error) => trim($error->message), $errors);
            libxml_clear_errors();
            throw new \Exception('Unable to parse RSS feed XML: '.implode('; ', array_filter($messages)));
        }

        $items = [];

        if (isset($xml->channel->item)) {
            foreach ($xml->channel->item as $item) {
                $items[] = $item;
            }
        } elseif (isset($xml->item)) {
            foreach ($xml->item as $item) {
                $items[] = $item;
            }
        }

        libxml_clear_errors();

        return $items;
    }

    protected function getElementText(\SimpleXMLElement $item, string $key): ?string
    {
        if (strpos($key, ':') === false) {
            return isset($item->{$key}) ? trim((string) $item->{$key}) : null;
        }

        [$prefix, $local] = explode(':', $key, 2);
        $namespaces = $item->getNamespaces(true);

        if (! isset($namespaces[$prefix])) {
            return null;
        }

        $child = $item->children($namespaces[$prefix])->{$local};

        return $child ? trim((string) $child) : null;
    }

    protected function parseDate(?string $value): Carbon
    {
        if (! $value) {
            return now();
        }

        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            Log::warning('Unable to parse RSS publish date', ['value' => $value]);

            return now();
        }
    }

    protected function resolveImageUrl(\SimpleXMLElement $item): ?string
    {
        if (isset($item->enclosure)) {
            $url = (string) $item->enclosure['url'];
            if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }
        }

        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content)) {
            $attributes = $media->content->attributes();
            if (isset($attributes['url'])) {
                $url = (string) $attributes['url'];
                if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
                    return $url;
                }
            }
        }

        return null;
    }

    /**
     * Create a news article from an RSS item.
     */
    protected function createNewsFromItem(RssFeed $feed, $item): News
    {
        $title = $this->getElementText($item, 'title') ?: 'Untitled';
        $content = $this->getElementText($item, 'content:encoded') ?: $this->getElementText($item, 'description') ?: '';
        $link = $this->getElementText($item, 'link') ?: '';
        $date = $this->parseDate($this->getElementText($item, 'pubDate'));

        // Extract image if available - note: storing external URLs without downloading
        // Images may break if source removes them. Consider downloading locally in production.
        $image = $this->resolveImageUrl($item);

        // Create excerpt from content
        $excerpt = strip_tags($content);
        if (strlen($excerpt) > 400) {
            $excerpt = substr($excerpt, 0, 400).'...';
        }

        // Get first admin user; abort if none found
        $adminUser = User::role('Administrator')->first();
        if (! $adminUser) {
            Log::error('RSS import failed: No admin user found to assign as news author.', [
                'feed_id' => $feed->id,
                'feed_name' => $feed->name,
                'item_title' => $title,
                'item_link' => $link,
            ]);
            throw new \Exception('No admin user found to assign as news author');
        }
        $userId = $adminUser->id;

        $news = News::create([
            'user_id' => $userId, // Use admin user
            'title' => $title,
            'slug' => null, // Will be auto-generated
            'excerpt' => $excerpt,
            'content' => $content,
            'image' => $image,
            'source' => $feed->name,
            'source_url' => $link,
            'is_published' => true,
            'is_featured' => false,
            'published_at' => $date,
            'views_count' => 0,
        ]);

        // Add tags from feed settings
        if (! empty($feed->settings['tags'])) {
            $news->syncTags($feed->settings['tags']);
        }

        return $news;
    }

    /**
     * Import from all active feeds that need refresh.
     */
    public function importAllFeeds(): array
    {
        $totalResults = [
            'success' => 0,
            'skipped' => 0,
            'errors' => 0,
            'messages' => [],
        ];

        $feeds = RssFeed::where('is_active', true)
            ->get()
            ->filter(fn ($feed) => $feed->needsRefresh());

        foreach ($feeds as $feed) {
            $results = $this->importFeed($feed);
            $totalResults['success'] += $results['success'];
            $totalResults['skipped'] += $results['skipped'];
            $totalResults['errors'] += $results['errors'];
            $totalResults['messages'] = array_merge($totalResults['messages'], $results['messages']);
        }

        return $totalResults;
    }
}
