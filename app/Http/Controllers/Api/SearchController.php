<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Forum\ForumThread;
use App\Models\Forum\ForumPost;
use App\Models\News;
use App\Models\User;
use App\Models\User\Gallery;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search across multiple models
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $query = $request->q;

        return response()->json([
            'threads' => ForumThread::search($query)->take(10)->get(),
            'posts' => ForumPost::search($query)->take(10)->get(),
            'news' => News::search($query)->take(10)->get(),
            'users' => User::search($query)->take(10)->get(),
            'media' => Gallery::search($query)->take(10)->get(),
        ]);
    }
}
