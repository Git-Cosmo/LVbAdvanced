<?php

namespace App\Services\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\ForumCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ForumService
{
    /**
     * Get all active forum categories with their forums.
     */
    public function getAllCategories(): Collection
    {
        return ForumCategory::active()
            ->with(['forums' => function ($query) {
                $query->active()
                    ->with(['lastPost.user', 'children'])
                    ->withCount(['threads', 'children']);
            }])
            ->orderBy('order')
            ->get();
    }

    /**
     * Get a forum by slug with related data.
     */
    public function getForumBySlug(string $slug): ?Forum
    {
        return Forum::where('slug', $slug)
            ->with(['category', 'parent', 'children'])
            ->firstOrFail();
    }

    /**
     * Create a new forum category.
     */
    public function createCategory(array $data): ForumCategory
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return ForumCategory::create($data);
    }

    /**
     * Create a new forum.
     */
    public function createForum(array $data): Forum
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return Forum::create($data);
    }

    /**
     * Update forum counters.
     */
    public function updateForumCounters(Forum $forum): void
    {
        $forum->threads_count = $forum->threads()->count();
        $forum->posts_count = $forum->threads()
            ->withCount('posts')
            ->get()
            ->sum('posts_count');

        $lastPost = $forum->threads()
            ->with('lastPost')
            ->latest('last_post_at')
            ->first()
            ?->lastPost;

        $forum->last_post_id = $lastPost?->id;
        $forum->save();
    }
}
