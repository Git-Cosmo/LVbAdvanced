<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    protected SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Display search results.
     */
    public function index(Request $request): View
    {
        $query = $request->input('q');
        $filter = $request->input('filter', 'all'); // all, threads, posts, users
        $forumId = $request->input('forum');
        $userId = $request->input('user');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $threads = collect();
        $posts = collect();
        $users = collect();

        if ($query) {
            $filters = array_filter([
                'forum_id' => $forumId,
                'user_id' => $userId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ]);

            if ($filter === 'threads') {
                $threads = $this->searchService->searchThreads($query, $filters);
            } elseif ($filter === 'posts') {
                $posts = $this->searchService->searchPosts($query, $filters);
            } elseif ($filter === 'users') {
                $users = $this->searchService->searchUsers($query);
            } else {
                // 'all' filter
                $threads = $this->searchService->searchThreads($query, $filters);
                $posts = $this->searchService->searchPosts($query, $filters);
                $users = $this->searchService->searchUsers($query);
            }
        }

        return view('forum.search', compact('query', 'filter', 'threads', 'posts', 'users', 'forumId', 'userId', 'dateFrom', 'dateTo'));
    }
}
