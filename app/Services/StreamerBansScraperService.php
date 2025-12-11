<?php

namespace App\Services;

use App\Models\StreamerBan;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;

class StreamerBansScraperService
{
    protected $client;
    protected $baseUrl = 'https://streamerbans.com';

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => true, // Keep SSL verification enabled for security
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ],
        ]);
    }

    /**
     * Scrape the list of all streamers from the main page.
     */
    public function scrapeStreamerList(): array
    {
        try {
            Log::info('Starting to scrape streamer list from ' . $this->baseUrl . '/streamers');
            
            $response = $this->client->get($this->baseUrl . '/streamers');
            $html = $response->getBody()->getContents();
            
            $crawler = new Crawler($html);
            $streamers = [];

            // Try multiple selectors to find streamer links
            // Common patterns: links containing /user/, streamer names in tables, etc.
            
            // Method 1: Find all links that match /user/ pattern
            $crawler->filter('a[href*="/user/"]')->each(function (Crawler $node) use (&$streamers) {
                $href = $node->attr('href');
                if (preg_match('/\/user\/([^\/\?]+)/', $href, $matches)) {
                    $username = $matches[1];
                    if (!in_array($username, $streamers)) {
                        $streamers[] = $username;
                    }
                }
            });

            // Method 2: If no streamers found, try looking for table rows or list items
            if (empty($streamers)) {
                $crawler->filter('table tr, ul li, .streamer-item')->each(function (Crawler $node) use (&$streamers) {
                    $node->filter('a')->each(function (Crawler $link) use (&$streamers) {
                        $href = $link->attr('href');
                        if (preg_match('/\/user\/([^\/\?]+)/', $href, $matches)) {
                            $username = $matches[1];
                            if (!in_array($username, $streamers)) {
                                $streamers[] = $username;
                            }
                        }
                    });
                });
            }

            Log::info('Found ' . count($streamers) . ' streamers on the main page');
            return $streamers;
        } catch (\Exception $e) {
            Log::error('Error scraping streamer list: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Scrape an individual streamer's page for ban details.
     */
    public function scrapeStreamerPage(string $username): ?array
    {
        try {
            $url = $this->baseUrl . '/user/' . $username;
            Log::info('Scraping streamer page: ' . $url);
            
            $response = $this->client->get($url);
            $html = $response->getBody()->getContents();
            
            $crawler = new Crawler($html);
            
            $data = [
                'username' => $username,
                'profile_url' => $url,
                'avatar_url' => null,
                'total_bans' => 0,
                'last_ban' => null,
                'longest_ban' => null,
                'ban_history' => [],
            ];

            // Extract avatar (common selectors)
            try {
                $avatar = $crawler->filter('img.avatar, img.profile-image, .user-avatar img, .streamer-avatar img')->first();
                if ($avatar->count() > 0) {
                    $data['avatar_url'] = $avatar->attr('src');
                }
            } catch (\Exception $e) {
                Log::debug('Could not find avatar for ' . $username);
            }

            // Extract total bans (look for text like "Total Bans: 5" or similar)
            try {
                $totalBansText = $crawler->filterXPath('//*[contains(text(), "Total") and contains(text(), "Ban")]')->first();
                if ($totalBansText->count() > 0) {
                    $text = $totalBansText->text();
                    if (preg_match('/(\d+)/', $text, $matches)) {
                        $data['total_bans'] = (int) $matches[1];
                    }
                }
            } catch (\Exception $e) {
                Log::debug('Could not find total bans for ' . $username);
            }

            // Alternative: Look for a stats section or card
            if ($data['total_bans'] === 0) {
                try {
                    $crawler->filter('.stat, .stats-item, .ban-stat, .metric')->each(function (Crawler $node) use (&$data) {
                        $text = $node->text();
                        if (stripos($text, 'total') !== false && stripos($text, 'ban') !== false) {
                            if (preg_match('/(\d+)/', $text, $matches)) {
                                $data['total_bans'] = (int) $matches[1];
                            }
                        }
                    });
                } catch (\Exception $e) {
                    Log::debug('Could not find total bans in stats section for ' . $username);
                }
            }

            // Extract last ban
            try {
                $lastBanText = $crawler->filterXPath('//*[contains(text(), "Last") and contains(text(), "Ban")]')->first();
                if ($lastBanText->count() > 0) {
                    $text = $lastBanText->text();
                    // Extract date pattern or duration
                    if (preg_match('/(\d{4}-\d{2}-\d{2}|\d+\s+(?:day|hour|minute)s?\s+ago)/', $text, $matches)) {
                        $data['last_ban'] = $matches[1];
                    }
                }
            } catch (\Exception $e) {
                Log::debug('Could not find last ban for ' . $username);
            }

            // Extract longest ban
            try {
                $longestBanText = $crawler->filterXPath('//*[contains(text(), "Longest") and contains(text(), "Ban")]')->first();
                if ($longestBanText->count() > 0) {
                    $text = $longestBanText->text();
                    // Extract duration
                    if (preg_match('/(\d+\s+(?:day|hour|minute)s?)/', $text, $matches)) {
                        $data['longest_ban'] = $matches[1];
                    }
                }
            } catch (\Exception $e) {
                Log::debug('Could not find longest ban for ' . $username);
            }

            // Extract ban history (look for tables, lists, or timeline elements)
            try {
                // Method 1: Table rows
                $crawler->filter('table.ban-history tr, table.bans-table tr, .ban-list tr')->each(function (Crawler $row, $i) use (&$data) {
                    if ($i === 0) return; // Skip header row
                    
                    $cells = $row->filter('td');
                    if ($cells->count() >= 2) {
                        $banEntry = [
                            'date' => trim($cells->eq(0)->text()),
                            'duration' => trim($cells->eq(1)->text()),
                            'reason' => $cells->count() > 2 ? trim($cells->eq(2)->text()) : null,
                        ];
                        $data['ban_history'][] = $banEntry;
                    }
                });

                // Method 2: List items
                if (empty($data['ban_history'])) {
                    $crawler->filter('ul.ban-history li, .ban-list-item, .ban-entry')->each(function (Crawler $item) use (&$data) {
                        $text = $item->text();
                        $banEntry = [
                            'text' => trim($text),
                        ];
                        
                        // Try to extract structured data from text
                        if (preg_match('/(\d{4}-\d{2}-\d{2})/', $text, $dateMatches)) {
                            $banEntry['date'] = $dateMatches[1];
                        }
                        if (preg_match('/(\d+\s+(?:day|hour|minute)s?)/', $text, $durationMatches)) {
                            $banEntry['duration'] = $durationMatches[1];
                        }
                        
                        $data['ban_history'][] = $banEntry;
                    });
                }
            } catch (\Exception $e) {
                Log::debug('Could not extract ban history for ' . $username);
            }

            Log::info('Successfully scraped data for ' . $username . ' - Total bans: ' . $data['total_bans']);
            return $data;
        } catch (\Exception $e) {
            Log::error('Error scraping streamer page for ' . $username . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save or update streamer data in the database.
     */
    public function saveStreamer(array $data): bool
    {
        try {
            StreamerBan::updateOrCreate(
                ['username' => $data['username']],
                [
                    'profile_url' => $data['profile_url'],
                    'avatar_url' => $data['avatar_url'],
                    'total_bans' => $data['total_bans'],
                    'last_ban' => $data['last_ban'],
                    'longest_ban' => $data['longest_ban'],
                    'ban_history' => $data['ban_history'],
                    'last_scraped_at' => now(),
                ]
            );

            Log::info('Saved/updated streamer: ' . $data['username']);
            return true;
        } catch (\Exception $e) {
            Log::error('Error saving streamer ' . $data['username'] . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Scrape all streamers from the list.
     */
    public function scrapeAll(): array
    {
        $streamers = $this->scrapeStreamerList();
        $results = [
            'total' => count($streamers),
            'success' => 0,
            'failed' => 0,
        ];

        foreach ($streamers as $username) {
            $data = $this->scrapeStreamerPage($username);
            
            if ($data && $this->saveStreamer($data)) {
                $results['success']++;
            } else {
                $results['failed']++;
            }

            // Be respectful: add a small delay between requests (1 second = 1,000,000 microseconds)
            usleep(1000000);
        }

        Log::info('Scraping complete. Total: ' . $results['total'] . ', Success: ' . $results['success'] . ', Failed: ' . $results['failed']);
        return $results;
    }

    /**
     * Scrape a specific streamer by username.
     */
    public function scrapeStreamer(string $username): bool
    {
        $data = $this->scrapeStreamerPage($username);
        
        if ($data) {
            return $this->saveStreamer($data);
        }

        return false;
    }

    /**
     * Update existing streamers (re-scrape their data).
     */
    public function updateExistingStreamers(int $limit = null): array
    {
        $query = StreamerBan::query();
        
        if ($limit) {
            $query->limit($limit);
        }

        $streamers = $query->orderBy('last_scraped_at', 'asc')->get();
        $results = [
            'total' => $streamers->count(),
            'success' => 0,
            'failed' => 0,
        ];

        foreach ($streamers as $streamer) {
            $data = $this->scrapeStreamerPage($streamer->username);
            
            if ($data && $this->saveStreamer($data)) {
                $results['success']++;
            } else {
                $results['failed']++;
            }

            // Be respectful: add a small delay between requests (1 second = 1,000,000 microseconds)
            usleep(1000000);
        }

        return $results;
    }
}
