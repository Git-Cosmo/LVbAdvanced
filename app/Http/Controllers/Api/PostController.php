<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Get list of posts
     */
    public function index(Request $request)
    {
        $posts = ForumPost::with(['user.profile', 'thread'])
            ->when($request->thread_id, function ($query, $threadId) {
                return $query->where('thread_id', $threadId);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json($posts);
    }

    /**
     * Create a new post
     */
    public function store(Request $request, ForumThread $thread)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post = $thread->posts()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($post->load('user.profile'), 201);
    }

    /**
     * Update a post
     */
    public function update(Request $request, ForumPost $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string',
        ]);

        $post->update([
            'content' => $request->content,
        ]);

        return response()->json($post);
    }

    /**
     * Delete a post
     */
    public function destroy(ForumPost $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    /**
     * React to a post
     */
    public function react(Request $request, ForumPost $post)
    {
        $request->validate([
            'type' => 'required|string|in:like,love,laugh,sad,angry',
        ]);

        $reaction = $post->reactions()->updateOrCreate(
            ['user_id' => $request->user()->id],
            ['type' => $request->type]
        );

        return response()->json($reaction);
    }
}
