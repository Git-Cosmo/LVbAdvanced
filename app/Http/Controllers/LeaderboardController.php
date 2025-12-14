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

        // Millionaire game high scores
        $topMillionaire = \App\Models\MillionaireAttempt::with('user')
            ->where('status', 'completed')
            ->orderBy('prize_won', 'desc')
            ->take(10)
            ->get();

        // GeoGuessr game high scores
        $topGeoguessr = \App\Models\GeoguessrAttempt::with('user')
            ->where('status', 'completed')
            ->orderBy('total_score', 'desc')
            ->take(10)
            ->get();

        return view('leaderboard.index', compact(
            'topByXp',
            'topByLevel',
            'topByKarma',
            'topPosters',
            'topByAchievements',
            'topMillionaire',
            'topGeoguessr'
        ));
    }
    
    public function millionaire(): View
    {
        $topScores = \App\Models\MillionaireAttempt::with(['user', 'millionaireGame'])
            ->where('status', 'completed')
            ->orderBy('prize_won', 'desc')
            ->paginate(50);

        $stats = [
            'total_games' => \App\Models\MillionaireAttempt::count(),
            'completed_games' => \App\Models\MillionaireAttempt::where('status', 'completed')->count(),
            'avg_prize' => \App\Models\MillionaireAttempt::where('status', 'completed')->avg('prize_won'),
            'highest_prize' => \App\Models\MillionaireAttempt::max('prize_won'),
        ];

        return view('leaderboard.millionaire', compact('topScores', 'stats'));
    }

    public function geoguessr(): View
    {
        $topScores = \App\Models\GeoguessrAttempt::with(['user', 'geoguessrGame'])
            ->where('status', 'completed')
            ->orderBy('total_score', 'desc')
            ->paginate(50);

        $stats = [
            'total_games' => \App\Models\GeoguessrAttempt::count(),
            'completed_games' => \App\Models\GeoguessrAttempt::where('status', 'completed')->count(),
            'avg_score' => \App\Models\GeoguessrAttempt::where('status', 'completed')->avg('total_score'),
            'highest_score' => \App\Models\GeoguessrAttempt::max('total_score'),
        ];

        return view('leaderboard.geoguessr', compact('topScores', 'stats'));
    }
}
