<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forum\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Get list of forums
     */
    public function index(Request $request)
    {
        $forums = Forum::with(['category', 'parent'])
            ->withCount(['threads', 'posts'])
            ->when($request->category_id, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->paginate($request->get('per_page', 20));

        return response()->json($forums);
    }

    /**
     * Get a specific forum with threads
     */
    public function show(Forum $forum)
    {
        $forum->load(['category', 'parent', 'subforums'])
            ->loadCount(['threads', 'posts']);

        return response()->json([
            'forum' => $forum,
            'threads' => $forum->threads()
                ->with(['user', 'lastPost.user'])
                ->withCount('posts')
                ->latest('is_pinned')
                ->latest('last_post_at')
                ->paginate(20),
        ]);
    }
}
