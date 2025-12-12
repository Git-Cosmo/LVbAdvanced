<?php

namespace App\Services\Forum;

use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ThreadService
{
    public function __construct(
        protected ForumService $forumService
    ) {}

    /**
     * Get threads for a forum with pagination.
     */
    public function getThreadsForForum(int $forumId, int $perPage = 20): LengthAwarePaginator
    {
        return ForumThread::where('forum_id', $forumId)
            ->with(['user.profile', 'lastPost.user'])
            ->withCount('posts')
            ->orderByDesc('is_pinned')
            ->orderByDesc('last_post_at')
            ->paginate($perPage);
    }

    /**
     * Get a thread by slug with posts.
     */
    public function getThreadBySlug(string $slug): ForumThread
    {
        $thread = ForumThread::where('slug', $slug)
            ->with(['forum', 'user.profile', 'poll.options'])
            ->firstOrFail();

        // Increment views
        $thread->incrementViews();

        return $thread;
    }

    /**
     * Get posts for a thread with pagination.
     */
    public function getPostsForThread(int $threadId, int $perPage = 20): LengthAwarePaginator
    {
        return ForumPost::where('thread_id', $threadId)
            ->with(['user.profile', 'attachments', 'reactions'])
            ->withCount('reactions')
            ->orderBy('created_at')
            ->paginate($perPage);
    }

    /**
     * Create a new thread.
     */
    public function createThread(array $data, User $user): ForumThread
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']).'-'.Str::random(8);
        $data['user_id'] = $user->id;

        $thread = ForumThread::create($data);

        // Update forum counters
        $this->forumService->updateForumCounters($thread->forum);

        return $thread;
    }

    /**
     * Create a post in a thread.
     */
    public function createPost(ForumThread $thread, array $data, User $user): ForumPost
    {
        $data['thread_id'] = $thread->id;
        $data['user_id'] = $user->id;

        // Convert content to HTML if needed
        if (! isset($data['content_html'])) {
            $data['content_html'] = $this->convertToHtml($data['content']);
        }

        $post = ForumPost::create($data);

        // Update thread counters
        $thread->increment('posts_count');
        $thread->last_post_id = $post->id;
        $thread->last_post_at = $post->created_at;
        $thread->save();

        // Update forum counters
        $this->forumService->updateForumCounters($thread->forum);

        // Award XP to user
        if ($user->profile) {
            $user->profile->addXp(10); // 10 XP per post
        }

        return $post;
    }

    /**
     * Update a post.
     */
    public function updatePost(ForumPost $post, array $data, User $editor): ForumPost
    {
        if (isset($data['content'])) {
            $data['content_html'] = $this->convertToHtml($data['content']);
        }

        $data['edited_at'] = now();
        $data['edited_by'] = $editor->id;
        $post->increment('edit_count');
        $post->update($data);

        return $post;
    }

    /**
     * Convert BBCode/Markdown content to HTML.
     * Note: For production, use a dedicated BBCode parser library like s9e/TextFormatter
     */
    protected function convertToHtml(string $content): string
    {
        // Escape HTML first to prevent XSS
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        // Convert newlines to br tags
        $content = nl2br($content);

        // Basic BBCode support with validation
        $content = preg_replace('/\[b\](.*?)\[\/b\]/s', '<strong>$1</strong>', $content);
        $content = preg_replace('/\[i\](.*?)\[\/i\]/s', '<em>$1</em>', $content);
        $content = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $content);

        // URL with validation - only allow http/https
        $content = preg_replace_callback(
            '/\[url=(https?:\/\/[^\]]+)\](.*?)\[\/url\]/s',
            function ($matches) {
                $url = filter_var($matches[1], FILTER_VALIDATE_URL);
                if ($url === false) {
                    return $matches[0]; // Return original if invalid
                }

                return '<a href="'.htmlspecialchars($url, ENT_QUOTES, 'UTF-8').'" target="_blank" rel="noopener noreferrer">'.$matches[2].'</a>';
            },
            $content
        );

        // Image with validation - only allow http/https
        $content = preg_replace_callback(
            '/\[img\](https?:\/\/[^\[]+)\[\/img\]/s',
            function ($matches) {
                $url = filter_var($matches[1], FILTER_VALIDATE_URL);
                if ($url === false) {
                    return $matches[0]; // Return original if invalid
                }

                return '<img src="'.htmlspecialchars($url, ENT_QUOTES, 'UTF-8').'" class="max-w-full h-auto" alt="User posted image" />';
            },
            $content
        );

        return $content;
    }
}
