<?php

namespace App\Http\Controllers;

use App\Services\ActivityFeedService;

class ActivityFeedController extends Controller
{
    protected ActivityFeedService $activityFeedService;

    public function __construct(ActivityFeedService $activityFeedService)
    {
        $this->activityFeedService = $activityFeedService;
    }

    /**
     * Show "What's New" feed
     */
    public function whatsNew()
    {
        $feed = $this->activityFeedService->getWhatsNew(30);

        return view('activity.whats-new', [
            'feed' => $feed,
            'page' => (object) [
                'title' => "What's New - FPSociety",
                'meta_title' => "What's New - Latest Gaming Content | FPSociety",
                'meta_description' => 'Stay updated with the latest posts, threads, and gaming content from the FPSociety community.',
            ],
        ]);
    }

    /**
     * Show trending threads
     */
    public function trending()
    {
        $trending = $this->activityFeedService->getTrending(20);

        return view('activity.trending', [
            'threads' => $trending,
            'page' => (object) [
                'title' => 'Trending - FPSociety',
                'meta_title' => 'Trending Gaming Discussions | FPSociety',
                'meta_description' => 'Discover the hottest gaming discussions, mods, and content trending in the FPSociety community.',
            ],
        ]);
    }

    /**
     * Show recent posts
     */
    public function recentPosts()
    {
        $posts = $this->activityFeedService->getRecentPosts(50);

        return view('activity.recent-posts', [
            'posts' => $posts,
            'page' => (object) [
                'title' => 'Recent Posts - FPSociety',
                'meta_title' => 'Recent Gaming Posts | FPSociety',
                'meta_description' => 'Browse the latest posts and replies from the FPSociety gaming community.',
            ],
        ]);
    }

    /**
     * Show recommended content
     */
    public function recommended()
    {
        $recommended = $this->activityFeedService->getRecommended(auth()->user(), 20);

        return view('activity.recommended', [
            'threads' => $recommended,
            'page' => (object) [
                'title' => 'Recommended - FPSociety',
                'meta_title' => 'Recommended Content | FPSociety',
                'meta_description' => 'Personalized gaming content recommendations based on your interests.',
            ],
        ]);
    }
}
