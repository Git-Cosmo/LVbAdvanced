<?php

namespace App\Services;

use App\Models\News;
use App\Models\RssFeed;
use App\Models\RssImportedItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimplePie\SimplePie;

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
            $simplePie = new SimplePie();
            $simplePie->set_feed_url($feed->url);
            $simplePie->init();
            $simplePie->handle_content_type();

            if ($simplePie->error()) {
                throw new \Exception($simplePie->error());
            }

            $items = $simplePie->get_items();

            foreach ($items as $item) {
                try {
                    $guid = $item->get_id() ?: $item->get_link();
                    
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
     * Create a news article from an RSS item.
     */
    protected function createNewsFromItem(RssFeed $feed, $item): News
    {
        $title = $item->get_title();
        $content = $item->get_content() ?: $item->get_description();
        $link = $item->get_link();
        $date = $item->get_date('Y-m-d H:i:s');

        // Extract image if available
        $image = null;
        $enclosure = $item->get_enclosure();
        if ($enclosure && $enclosure->get_thumbnail()) {
            $image = $enclosure->get_thumbnail();
        }

        // Create excerpt from content
        $excerpt = strip_tags($content);
        $excerpt = substr($excerpt, 0, 400);
        if (strlen(strip_tags($content)) > 400) {
            $excerpt .= '...';
        }

        // Get first admin user or fallback to user ID 1
        $adminUser = \App\Models\User::role('Administrator')->first();
        $userId = $adminUser ? $adminUser->id : 1;
        
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
            'published_at' => $date ?: now(),
            'views_count' => 0,
        ]);

        // Add tags from feed settings
        if (!empty($feed->settings['tags'])) {
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
            ->filter(fn($feed) => $feed->needsRefresh());

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
