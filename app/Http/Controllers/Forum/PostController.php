<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Services\Forum\ThreadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected ThreadService $threadService
    ) {}

    /**
     * Store a newly created post in a thread.
     */
    public function store(Request $request, ForumThread $thread): RedirectResponse
    {
        $this->authorize('create', [ForumPost::class, $thread]);
        
        $validated = $request->validate([
            'content' => 'required|string',
            'reply_to_id' => 'nullable|exists:forum_posts,id',
        ]);
        
        $this->threadService->createPost($thread, $validated, $request->user());
        
        return redirect()->route('forum.thread.show', $thread->slug)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Update an existing post.
     */
    public function update(Request $request, ForumPost $post): RedirectResponse
    {
        $this->authorize('update', $post);
        
        $validated = $request->validate([
            'content' => 'required|string',
        ]);
        
        $this->threadService->updatePost($post, $validated, $request->user());
        
        return redirect()->route('forum.thread.show', $post->thread->slug)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove a post.
     */
    public function destroy(ForumPost $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        
        $threadSlug = $post->thread->slug;
        $post->delete();
        
        return redirect()->route('forum.thread.show', $threadSlug)
            ->with('success', 'Post deleted successfully!');
    }
}

