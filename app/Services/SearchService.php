<?php

namespace App\Services;

use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SearchService
{
    /**
     * Perform a full-text search across threads with relevancy ranking.
     */
    public function searchThreads(string $query, array $filters = [], int $perPage = 15)
    {
        $threadsQuery = ForumThread::with(['user', 'forum'])
            ->where('is_hidden', false)
            ->select('forum_threads.*')
            ->selectRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE) as relevance", [$query])
            ->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$query]);

        // Apply filters
        if (!empty($filters['forum_id'])) {
            $threadsQuery->where('forum_id', $filters['forum_id']);
        }

        if (!empty($filters['user_id'])) {
            $threadsQuery->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $threadsQuery->where('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $threadsQuery->where('created_at', '<=', $filters['date_to']);
        }

        return $threadsQuery->orderByDesc('relevance')
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'threads_page');
    }

    /**
     * Perform a full-text search across posts with relevancy ranking.
     */
    public function searchPosts(string $query, array $filters = [], int $perPage = 15)
    {
        $postsQuery = ForumPost::with(['user', 'thread.forum'])
            ->where('is_hidden', false)
            ->select('forum_posts.*')
            ->selectRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE) as relevance", [$query])
            ->whereRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE)", [$query]);

        // Apply filters
        if (!empty($filters['user_id'])) {
            $postsQuery->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $postsQuery->where('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $postsQuery->where('created_at', '<=', $filters['date_to']);
        }

        return $postsQuery->orderByDesc('relevance')
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'posts_page');
    }

    /**
     * Search news articles with relevancy ranking.
     */
    public function searchNews(string $query, int $perPage = 15)
    {
        return News::published()
            ->with('user')
            ->select('news.*')
            ->selectRaw("MATCH(title, excerpt, content) AGAINST(? IN BOOLEAN MODE) as relevance", [$query])
            ->whereRaw("MATCH(title, excerpt, content) AGAINST(? IN BOOLEAN MODE)", [$query])
            ->orderByDesc('relevance')
            ->orderByDesc('published_at')
            ->paginate($perPage, ['*'], 'news_page');
    }

    /**
     * Search users.
     */
    public function searchUsers(string $query, int $perPage = 15)
    {
        return User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->withCount(['threads', 'posts'])
            ->paginate($perPage, ['*'], 'users_page');
    }

    /**
     * Perform a comprehensive search across all content types.
     */
    public function searchAll(string $query, array $filters = [])
    {
        $results = [
            'threads' => $this->searchThreads($query, $filters, 10),
            'posts' => $this->searchPosts($query, $filters, 10),
            'news' => $this->searchNews($query, 5),
            'users' => $this->searchUsers($query, 5),
        ];

        // Calculate total results
        $results['total'] = $results['threads']->total() + 
                           $results['posts']->total() + 
                           $results['news']->total() + 
                           $results['users']->total();

        return $results;
    }
}
