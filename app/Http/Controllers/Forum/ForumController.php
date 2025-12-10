<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\Forum\ForumService;
use App\Services\Forum\ThreadService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function __construct(
        protected ForumService $forumService,
        protected ThreadService $threadService
    ) {}

    /**
     * Display the forum index with all categories and forums.
     */
    public function index(): View
    {
        $categories = $this->forumService->getAllCategories();
        
        return view('forum.index', compact('categories'));
    }

    /**
     * Display a specific forum with its threads.
     */
    public function show(string $slug): View
    {
        $forum = $this->forumService->getForumBySlug($slug);
        $threads = $this->threadService->getThreadsForForum($forum->id);
        
        return view('forum.show', compact('forum', 'threads'));
    }
}

