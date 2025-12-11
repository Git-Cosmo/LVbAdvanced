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
            Log::debug('Streamer list page HTML: ' . substr($html, 0, 2000)); // Log first 2000 chars for debug
            $crawler = new Crawler($html);
            $streamers = [];

            // New: Use the actual structure from the latest site
            // The streamer list is in a <ul> with grid classes, each <li> contains an <a href="/user/username">
            $crawler->filter('ul.grid > li')->each(function (Crawler $li) use (&$streamers) {
                $a = $li->filter('a[href^="/user/"]');
                if ($a->count() > 0) {
                    $href = $a->attr('href');
                    if (preg_match('/\/user\/([^\/\?]+)/', $href, $matches)) {
                        $username = $matches[1];
                        if (!in_array($username, $streamers)) {
                            $streamers[] = $username;
                        }
                    }
                }
            });

            // Fallback: If not found, try all a[href^="/user/"]
            if (empty($streamers)) {
                $crawler->filter('a[href^="/user/"]')->each(function (Crawler $a) use (&$streamers) {
                    $href = $a->attr('href');
                    if (preg_match('/\/user\/([^\/\?]+)/', $href, $matches)) {
                        $username = $matches[1];
                        if (!in_array($username, $streamers)) {
                            $streamers[] = $username;
                        }
                    }
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
            Log::debug('Streamer page HTML for ' . $username . ': ' . substr($html, 0, 2000));
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

            // Extract avatar: look for the main profile image in the streamer card
            try {
                $img = $crawler->filter('a[href^="/user/"] img, .overflow-hidden img, img[alt]')->first();
                if ($img->count() > 0) {
                    $data['avatar_url'] = $img->attr('src');
                }
            } catch (\Exception $e) {
                Log::debug('Could not find avatar for ' . $username);
            }

            // Extract stats: find all <dt> and <dd> pairs in the stats section
            try {
                $crawler->filter('dl.grid > div')->each(function (Crawler $div) use (&$data) {
                    $dt = $div->filter('dt');
                    $dd = $div->filter('dd');
                    if ($dt->count() && $dd->count()) {
                        $label = trim($dt->text());
                        $value = trim($dd->text());
                        if (stripos($label, 'Total Bans') !== false) {
                            $data['total_bans'] = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                        } elseif (stripos($label, 'Last Ban') !== false) {
                            $data['last_ban'] = $value;
                        } elseif (stripos($label, 'Longest Ban') !== false) {
                            $data['longest_ban'] = $value;
                        }
                    }
                });
            } catch (\Exception $e) {
                Log::debug('Could not extract stats for ' . $username);
            }

            // Extract ban history: look for the Recent Activity table
            try {
                $crawler->filter('table tr')->each(function (Crawler $row, $i) use (&$data) {
                    if ($i === 0) return; // skip header
                    $cells = $row->filter('td');
                    if ($cells->count() === 3) {
                        $activity = trim($cells->eq(1)->text());
                        $date = trim($cells->eq(2)->text());
                        $data['ban_history'][] = [
                            'activity' => $activity,
                            'date' => $date,
                        ];
                    }
                });
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
