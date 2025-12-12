<?php

namespace App\Services;

use App\Models\RedditPost;
use App\Models\RedditSubreddit;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RedditScraperService
{
    protected $client;

    protected $accessToken;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
        ]);
    }

    /**
     * Authenticate with Reddit API using password grant.
     */
    protected function authenticate(): bool
    {
        $clientId = config('services.reddit.client_id');
        $clientSecret = config('services.reddit.client_secret');
        $username = config('services.reddit.username');
        $password = config('services.reddit.password');

        if (! $clientId || ! $clientSecret || ! $username || ! $password) {
            Log::error('Reddit credentials not configured');

            return false;
        }

        try {
            $response = $this->client->post('https://www.reddit.com/api/v1/access_token', [
                'auth' => [$clientId, $clientSecret],
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => $username,
                    'password' => $password,
                ],
                'headers' => [
                    'User-Agent' => 'Laravel/FetchAITAH',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (isset($data['access_token'])) {
                $this->accessToken = $data['access_token'];
                Log::info('Reddit authentication successful');

                return true;
            }

            Log::error('Reddit authentication failed: No access token in response');

            return false;
        } catch (\Exception $e) {
            Log::error('Reddit authentication error: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Scrape posts from a specific subreddit.
     */
    public function scrapeSubreddit(string $subredditName, int $limit = 25): int
    {
        if (! $this->authenticate()) {
            return 0;
        }

        try {
            $response = $this->client->get("https://oauth.reddit.com/r/{$subredditName}/hot", [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->accessToken,
                    'User-Agent' => 'Laravel/FetchAITAH',
                ],
                'query' => [
                    'limit' => $limit,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (! isset($data['kind']) || $data['kind'] !== 'Listing') {
                Log::error('Invalid Reddit API response structure');

                return 0;
            }

            $posts = $data['data']['children'] ?? [];
            $importedCount = 0;

            foreach ($posts as $postData) {
                if (! isset($postData['data'])) {
                    continue;
                }

                $post = $postData['data'];

                if ($this->savePost($post, $subredditName)) {
                    $importedCount++;
                }
            }

            Log::info("Scraped {$importedCount} posts from r/{$subredditName}");

            return $importedCount;
        } catch (\Exception $e) {
            Log::error("Error scraping r/{$subredditName}: ".$e->getMessage());

            return 0;
        }
    }

    /**
     * Save or update a Reddit post.
     */
    protected function savePost(array $postData, string $subreddit): bool
    {
        try {
            $redditId = $postData['id'] ?? null;

            if (! $redditId) {
                return false;
            }

            // Extract media information
            $media = null;
            $isVideo = false;

            if (isset($postData['is_video']) && $postData['is_video']) {
                $isVideo = true;
                $media = [
                    'reddit_video' => $postData['media']['reddit_video'] ?? null,
                    'preview' => $postData['preview'] ?? null,
                ];
            } elseif (isset($postData['media']) && $postData['media']) {
                $media = $postData['media'];
            } elseif (isset($postData['preview'])) {
                $media = ['preview' => $postData['preview']];
            }

            // Check if post exists and update or create
            $post = RedditPost::updateOrCreate(
                ['reddit_id' => $redditId],
                [
                    'subreddit' => $subreddit,
                    'title' => $postData['title'] ?? '',
                    'body' => $postData['selftext'] ?? null,
                    'author' => $postData['author'] ?? null,
                    'flair' => $postData['link_flair_text'] ?? null,
                    'url' => $postData['url'] ?? null,
                    'permalink' => $postData['permalink'] ?? null,
                    'score' => $postData['score'] ?? 0,
                    'num_comments' => $postData['num_comments'] ?? 0,
                    'posted_at' => isset($postData['created_utc'])
                        ? Carbon::createFromTimestamp($postData['created_utc'])
                        : null,
                    'thumbnail' => ($postData['thumbnail'] ?? '') !== 'self' && ($postData['thumbnail'] ?? '') !== 'default'
                        ? $postData['thumbnail']
                        : null,
                    'media' => $media,
                    'post_hint' => $postData['post_hint'] ?? null,
                    'is_video' => $isVideo,
                    'is_self' => $postData['is_self'] ?? false,
                ]
            );

            return true;
        } catch (\Exception $e) {
            Log::error('Error saving Reddit post: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Scrape all enabled subreddits.
     */
    public function scrapeAll(): array
    {
        $subreddits = RedditSubreddit::enabled()->get();
        $results = [];

        foreach ($subreddits as $subreddit) {
            $count = $this->scrapeSubreddit($subreddit->name, $subreddit->scrape_limit);

            $subreddit->update([
                'last_scraped_at' => now(),
            ]);

            $results[$subreddit->name] = $count;
        }

        return $results;
    }
}
