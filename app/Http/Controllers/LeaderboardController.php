<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard page.
     */
    public function index(): View
    {
        // Top users by XP
        $topByXp = User::with('profile')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->select('users.*')
            ->orderBy('user_profiles.xp', 'desc')
            ->take(10)
            ->get();

        // Top users by Level
        $topByLevel = User::with('profile')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->select('users.*')
            ->orderBy('user_profiles.level', 'desc')
            ->orderBy('user_profiles.xp', 'desc')
            ->take(10)
            ->get();

        // Top users by Karma
        $topByKarma = User::with('profile')
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->select('users.*')
            ->orderBy('user_profiles.karma', 'desc')
            ->take(10)
            ->get();

        // Top posters
        $topPosters = User::with('profile')
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        // Most achievements
        $topByAchievements = User::with('profile')
            ->withCount('achievements')
            ->orderBy('achievements_count', 'desc')
            ->take(10)
            ->get();

        return view('leaderboard.index', compact(
            'topByXp',
            'topByLevel',
            'topByKarma',
            'topPosters',
            'topByAchievements'
        ));
    }
}
