<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User\UserAchievement;
use App\Models\User\UserBadge;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    /**
     * Display all achievements and badges.
     */
    public function index(): View
    {
        $achievements = UserAchievement::where('is_active', true)
            ->withCount('users')
            ->orderBy('points', 'desc')
            ->get();

        $badges = UserBadge::where('is_active', true)
            ->withCount('users')
            ->orderBy('points', 'desc')
            ->get();

        $topAchievers = User::withCount(['achievements' => function ($query) {
                $query->where('is_unlocked', true);
            }])
            ->orderBy('achievements_count', 'desc')
            ->take(10)
            ->get();

        $stats = [
            'total_achievements' => $achievements->count(),
            'total_badges' => $badges->count(),
            'total_unlocks' => $achievements->sum('users_count'),
        ];

        return view('achievements.index', compact('achievements', 'badges', 'topAchievers', 'stats'));
    }

    /**
     * Display a user's achievements and badges.
     */
    public function user(User $user): View
    {
        $user->load([
            'achievements' => function ($query) {
                $query->orderBy('pivot_unlocked_at', 'desc');
            },
            'badges' => function ($query) {
                $query->orderBy('pivot_awarded_at', 'desc');
            }
        ]);

        $unlockedAchievements = $user->achievements()
            ->wherePivot('is_unlocked', true)
            ->get();

        $lockedAchievements = UserAchievement::where('is_active', true)
            ->whereNotIn('id', $unlockedAchievements->pluck('id'))
            ->get();

        $stats = [
            'total_achievements' => $unlockedAchievements->count(),
            'total_badges' => $user->badges->count(),
            'total_points' => $unlockedAchievements->sum('points') + $user->badges->sum('points'),
            'completion_rate' => UserAchievement::where('is_active', true)->count() > 0 
                ? round(($unlockedAchievements->count() / UserAchievement::where('is_active', true)->count()) * 100, 1)
                : 0,
        ];

        return view('achievements.user', compact('user', 'unlockedAchievements', 'lockedAchievements', 'stats'));
    }
}
