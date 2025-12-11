<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use App\Models\News;
use App\Models\RedditPost;
use App\Models\StreamerBan;
use App\Models\User\Gallery;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    /**
     * Generate and return the sitemap.
     */
    public function index()
    {
        $sitemap = Sitemap::create();

        // Add homepage
        $sitemap->add(
            Url::create(route('portal.home'))
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        );

        // Add static pages
        $staticPages = [
            ['url' => route('forum.index'), 'priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_HOURLY],
            ['url' => route('downloads.index'), 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('activity.whats-new'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_HOURLY],
            ['url' => route('leaderboard.index'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('news.index'), 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_HOURLY],
            ['url' => route('events.index'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('clips.index'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_HOURLY],
            ['url' => route('streamerbans.index'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('games.deals'), 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('games.stores'), 'priority' => 0.6, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['url' => route('terms'), 'priority' => 0.3, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['url' => route('privacy'), 'priority' => 0.3, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['url' => route('contact'), 'priority' => 0.5, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($page['url'])
                    ->setLastModificationDate(now())
                    ->setChangeFrequency($page['frequency'])
                    ->setPriority($page['priority'])
            );
        }

        // Add forums
        Forum::chunk(100, function ($forums) use ($sitemap) {
            foreach ($forums as $forum) {
                $sitemap->add(
                    Url::create(route('forum.show', $forum))
                        ->setLastModificationDate($forum->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                        ->setPriority(0.8)
                );
            }
        });

        // Add forum threads (limited to recent ones for performance)
        ForumThread::where('is_hidden', false)
            ->orderBy('updated_at', 'desc')
            ->limit(1000)
            ->chunk(100, function ($threads) use ($sitemap) {
                foreach ($threads as $thread) {
                    $sitemap->add(
                        Url::create(route('forum.thread.show', [$thread->forum, $thread]))
                            ->setLastModificationDate($thread->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                            ->setPriority(0.6)
                    );
                }
            });

        // Add published news articles
        News::published()
            ->orderBy('published_at', 'desc')
            ->limit(500)
            ->chunk(100, function ($newsArticles) use ($sitemap) {
                foreach ($newsArticles as $news) {
                    $sitemap->add(
                        Url::create(route('news.show', $news))
                            ->setLastModificationDate($news->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.7)
                    );
                }
            });

        // Add downloads (galleries)
        Gallery::orderBy('updated_at', 'desc')
            ->limit(500)
            ->chunk(100, function ($galleries) use ($sitemap) {
                foreach ($galleries as $gallery) {
                    $sitemap->add(
                        Url::create(route('downloads.show', $gallery))
                            ->setLastModificationDate($gallery->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.6)
                    );
                }
            });

        // Add events
        Event::where('start_date', '>=', now()->subMonths(3))
            ->orderBy('start_date', 'desc')
            ->limit(500)
            ->chunk(100, function ($events) use ($sitemap) {
                foreach ($events as $event) {
                    $sitemap->add(
                        Url::create(route('events.show', $event))
                            ->setLastModificationDate($event->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.6)
                    );
                }
            });

        // Add streamer bans (featured and recent)
        StreamerBan::where('is_featured', true)
            ->orWhere('updated_at', '>=', now()->subMonths(6))
            ->orderBy('updated_at', 'desc')
            ->limit(500)
            ->chunk(100, function ($streamerBans) use ($sitemap) {
                foreach ($streamerBans as $ban) {
                    $sitemap->add(
                        Url::create(route('streamerbans.show', $ban))
                            ->setLastModificationDate($ban->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.5)
                    );
                }
            });

        // Add popular Reddit clips
        RedditPost::where('score', '>', 100)
            ->orderBy('created_at', 'desc')
            ->limit(300)
            ->chunk(100, function ($posts) use ($sitemap) {
                foreach ($posts as $post) {
                    $sitemap->add(
                        Url::create(route('reddit.show', $post))
                            ->setLastModificationDate($post->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.5)
                    );
                }
            });

        return $sitemap->toResponse(request());
    }
}
