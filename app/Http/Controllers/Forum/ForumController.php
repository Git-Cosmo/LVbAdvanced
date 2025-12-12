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
    public function show(Request $request, string $slug): View
    {
        $forum = $this->forumService->getForumBySlug($slug);

        // Get sort and filter parameters
        $sort = $request->input('sort', 'latest'); // latest, popular, views, oldest
        $filter = $request->input('filter', 'all'); // all, pinned, locked

        $threadsQuery = $forum->threads()
            ->with(['user', 'forum'])
            ->where('is_hidden', false);

        // Apply filters
        if ($filter === 'pinned') {
            $threadsQuery->where('is_pinned', true);
        } elseif ($filter === 'locked') {
            $threadsQuery->where('is_locked', true);
        }

        // Apply sorting
        switch ($sort) {
            case 'popular':
                $threadsQuery->orderByDesc('posts_count');
                break;
            case 'views':
                $threadsQuery->orderByDesc('views_count');
                break;
            case 'oldest':
                $threadsQuery->orderBy('created_at');
                break;
            case 'latest':
            default:
                $threadsQuery->orderByDesc('is_pinned')
                    ->orderByDesc('last_post_at')
                    ->orderByDesc('created_at');
                break;
        }

        $threads = $threadsQuery->paginate(20);

        return view('forum.show', compact('forum', 'threads', 'sort', 'filter'));
    }
}
