<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Get list of threads
     */
    public function index(Request $request)
    {
        $threads = ForumThread::with(['user', 'forum', 'lastPost.user'])
            ->withCount('posts')
            ->when($request->forum_id, function ($query, $forumId) {
                return $query->where('forum_id', $forumId);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->latest('last_post_at')
            ->paginate($request->get('per_page', 20));

        return response()->json($threads);
    }

    /**
     * Get a specific thread with posts
     */
    public function show(ForumThread $thread)
    {
        $thread->load(['user', 'forum', 'poll.options'])
            ->loadCount('posts');

        return response()->json([
            'thread' => $thread,
            'posts' => $thread->posts()
                ->with(['user.profile', 'reactions'])
                ->paginate(20),
        ]);
    }

    /**
     * Create a new thread
     */
    public function store(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thread = $forum->threads()->create([
            'title' => $request->title,
            'user_id' => $request->user()->id,
        ]);

        $thread->posts()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($thread->load('posts'), 201);
    }

    /**
     * Update a thread
     */
    public function update(Request $request, ForumThread $thread)
    {
        $this->authorize('update', $thread);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'is_pinned' => 'sometimes|boolean',
            'is_locked' => 'sometimes|boolean',
        ]);

        $thread->update($request->only(['title', 'is_pinned', 'is_locked']));

        return response()->json($thread);
    }

    /**
     * Delete a thread
     */
    public function destroy(ForumThread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return response()->json(['message' => 'Thread deleted successfully']);
    }

    /**
     * Subscribe to a thread
     */
    public function subscribe(Request $request, ForumThread $thread)
    {
        $request->user()->subscriptions()->firstOrCreate([
            'subscribable_type' => ForumThread::class,
            'subscribable_id' => $thread->id,
        ]);

        return response()->json(['message' => 'Subscribed successfully']);
    }

    /**
     * Unsubscribe from a thread
     */
    public function unsubscribe(Request $request, ForumThread $thread)
    {
        $request->user()->subscriptions()
            ->where('subscribable_type', ForumThread::class)
            ->where('subscribable_id', $thread->id)
            ->delete();

        return response()->json(['message' => 'Unsubscribed successfully']);
    }
}
