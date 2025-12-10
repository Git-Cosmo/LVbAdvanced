<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
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
            if (in_array($filter, ['all', 'threads'])) {
                $threadsQuery = ForumThread::with(['user', 'forum'])
                    ->where('is_hidden', false)
                    ->where(function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%");
                    });
                
                if ($forumId) {
                    $threadsQuery->where('forum_id', $forumId);
                }
                
                if ($userId) {
                    $threadsQuery->where('user_id', $userId);
                }
                
                if ($dateFrom) {
                    $threadsQuery->where('created_at', '>=', $dateFrom);
                }
                
                if ($dateTo) {
                    $threadsQuery->where('created_at', '<=', $dateTo);
                }
                
                $threads = $threadsQuery->orderByDesc('created_at')->paginate(15, ['*'], 'threads_page');
            }
            
            if (in_array($filter, ['all', 'posts'])) {
                $postsQuery = ForumPost::with(['user', 'thread.forum'])
                    ->where('is_hidden', false)
                    ->where(function($q) use ($query) {
                        $q->where('content', 'like', "%{$query}%");
                    });
                
                if ($userId) {
                    $postsQuery->where('user_id', $userId);
                }
                
                if ($dateFrom) {
                    $postsQuery->where('created_at', '>=', $dateFrom);
                }
                
                if ($dateTo) {
                    $postsQuery->where('created_at', '<=', $dateTo);
                }
                
                $posts = $postsQuery->orderByDesc('created_at')->paginate(15, ['*'], 'posts_page');
            }
            
            if (in_array($filter, ['all', 'users'])) {
                $users = User::where('name', 'like', "%{$query}%")
                    ->withCount('threads', 'posts')
                    ->paginate(15, ['*'], 'users_page');
            }
        }
        
        return view('forum.search', compact('query', 'filter', 'threads', 'posts', 'users', 'forumId', 'userId', 'dateFrom', 'dateTo'));
    }
}
