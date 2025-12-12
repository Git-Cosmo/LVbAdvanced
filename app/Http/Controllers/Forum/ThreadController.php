<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use App\Services\Forum\ThreadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThreadController extends Controller
{
    public function __construct(
        protected ThreadService $threadService,
        protected \App\Services\GamificationService $gamificationService
    ) {}

    /**
     * Display a specific thread with its posts.
     */
    public function show(string $slug): View
    {
        $thread = $this->threadService->getThreadBySlug($slug);
        $posts = $this->threadService->getPostsForThread($thread->id);

        return view('forum.thread.show', compact('thread', 'posts'));
    }

    /**
     * Show the form for creating a new thread.
     */
    public function create(Forum $forum): View
    {
        $this->authorize('create', [ForumThread::class, $forum]);

        return view('forum.thread.create', compact('forum'));
    }

    /**
     * Store a newly created thread.
     */
    public function store(Request $request, Forum $forum): RedirectResponse
    {
        $this->authorize('create', [ForumThread::class, $forum]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thread = $this->threadService->createThread([
            'forum_id' => $forum->id,
            'title' => $validated['title'],
        ], $request->user());

        // Create first post
        $this->threadService->createPost($thread, [
            'content' => $validated['content'],
        ], $request->user());

        // Award XP for creating a thread
        $this->gamificationService->awardActionXP($request->user(), 'create_thread');

        return redirect()->route('forum.thread.show', $thread->slug)
            ->with('success', 'Thread created successfully!');
    }
}
