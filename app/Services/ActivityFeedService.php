<?php

namespace App\Services;

use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use Illuminate\Support\Facades\Cache;

class ActivityFeedService
{
    /**
     * Get global "What's New" feed
     */
    public function getWhatsNew(int $limit = 20)
    {
        return Cache::remember('feed:whats-new', 300, function () use ($limit) {
            $threads = ForumThread::with(['user', 'forum', 'latestPost'])
                ->latest()
                ->limit($limit)
                ->get()
                ->map(fn ($thread) => [
                    'type' => 'thread',
                    'data' => $thread,
                    'timestamp' => $thread->created_at,
                ]);

            $posts = ForumPost::with(['user', 'thread', 'thread.forum'])
                ->latest()
                ->limit($limit)
                ->get()
                ->map(fn ($post) => [
                    'type' => 'post',
                    'data' => $post,
                    'timestamp' => $post->created_at,
                ]);

            return $threads->concat($posts)
                ->sortByDesc('timestamp')
                ->take($limit)
                ->values();
        });
    }

    /**
     * Get trending threads (based on activity and reactions)
     */
    public function getTrending(int $limit = 10, int $days = 7)
    {
        $since = now()->subDays($days);

        return ForumThread::query()
            ->with(['user', 'forum'])
            ->withCount([
                'posts as recent_posts_count' => function ($query) use ($since) {
                    $query->where('created_at', '>=', $since);
                },
                'reactions as recent_reactions_count' => function ($query) use ($since) {
                    $query->where('created_at', '>=', $since);
                },
            ])
            ->where('created_at', '>=', now()->subDays($days * 2))
            ->get()
            ->map(function ($thread) {
                // Calculate trending score
                $thread->trending_score = ($thread->recent_posts_count * 2) +
                                         ($thread->recent_reactions_count * 3) +
                                         ($thread->views / 10);

                return $thread;
            })
            ->sortByDesc('trending_score')
            ->take($limit)
            ->values();
    }

    /**
     * Get recommended content for a user
     */
    public function getRecommended($user, int $limit = 10)
    {
        if (! $user) {
            // For guests, return popular content
            return $this->getTrending($limit);
        }

        // Get user's subscribed forums
        $subscribedForums = $user->subscribedForums()->pluck('forum_id');

        // Get threads from subscribed forums
        $recommended = ForumThread::query()
            ->with(['user', 'forum'])
            ->whereIn('forum_id', $subscribedForums)
            ->where('user_id', '!=', $user->id)
            ->latest()
            ->limit($limit)
            ->get();

        // If not enough, add trending
        if ($recommended->count() < $limit) {
            $trending = $this->getTrending($limit - $recommended->count());
            $recommended = $recommended->concat($trending)->unique('id');
        }

        return $recommended->take($limit);
    }

    /**
     * Get recent posts across all forums
     */
    public function getRecentPosts(int $limit = 20)
    {
        return ForumPost::with(['user', 'thread', 'thread.forum'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
