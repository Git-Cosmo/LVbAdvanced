<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\UserProfile;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboards.
     */
    public function index(): View
    {
        $topByXP = UserProfile::with('user')
            ->orderByDesc('xp')
            ->take(20)
            ->get();
        
        $topByLevel = UserProfile::with('user')
            ->orderByDesc('level')
            ->take(20)
            ->get();
        
        $topByKarma = UserProfile::with('user')
            ->orderByDesc('karma')
            ->take(20)
            ->get();
        
        $topByPosts = User::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(20)
            ->get();
        
        return view('forum.leaderboard.index', compact('topByXP', 'topByLevel', 'topByKarma', 'topByPosts'));
    }
}
