<?php

namespace App\Http\Controllers;

use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use App\Models\News;
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
            ['url' => route('media.index'), 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('activity.whats-new'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_HOURLY],
            ['url' => route('leaderboard.index'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
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
        Forum::chunk(50, function ($forums) use ($sitemap) {
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

        // Add galleries
        Gallery::orderBy('updated_at', 'desc')
            ->limit(500)
            ->chunk(100, function ($galleries) use ($sitemap) {
                foreach ($galleries as $gallery) {
                    $sitemap->add(
                        Url::create(route('media.show', $gallery))
                            ->setLastModificationDate($gallery->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.6)
                    );
                }
            });

        return $sitemap->toResponse(request());
    }
}
