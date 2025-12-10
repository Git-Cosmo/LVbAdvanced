<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class GamificationService
{
    protected ReputationService $reputationService;

    public function __construct(ReputationService $reputationService)
    {
        $this->reputationService = $reputationService;
    }

    /**
     * Award XP for various actions
     */
    public function awardActionXP(User $user, string $action): void
    {
        $xpAmounts = [
            'create_thread' => 15,
            'create_post' => 10,
            'receive_like' => 5,
            'daily_login' => 5,
            'profile_complete' => 50,
            'first_post' => 25,
            'poll_create' => 10,
            'poll_vote' => 2,
        ];

        $amount = $xpAmounts[$action] ?? 0;
        
        if ($amount > 0) {
            $this->reputationService->awardXP($user, $amount, $action);
            $this->checkStreaks($user, $action);
        }
    }

    /**
     * Check and update user streaks
     */
    public function checkStreaks(User $user, string $action): void
    {
        if ($action === 'daily_login') {
            $lastLogin = $user->profile->last_login_at;
            $today = Carbon::today();
            
            if ($lastLogin && $lastLogin->isYesterday()) {
                // Continue streak
                $user->profile->increment('login_streak');
            } elseif (!$lastLogin || !$lastLogin->isToday()) {
                // Reset or start streak
                $user->profile->update(['login_streak' => 1]);
            }
            
            $user->profile->update(['last_login_at' => now()]);
            
            // Award streak milestones
            $this->checkStreakMilestones($user);
        }
        
        if (in_array($action, ['create_thread', 'create_post'])) {
            $this->checkPostingStreak($user);
        }
    }

    /**
     * Check streak milestones and award badges
     */
    protected function checkStreakMilestones(User $user): void
    {
        $streak = $user->profile->login_streak;
        $milestones = [
            7 => ['name' => 'Week Warrior', 'description' => '7 day login streak'],
            30 => ['name' => 'Monthly Dedication', 'description' => '30 day login streak'],
            100 => ['name' => 'Century Club', 'description' => '100 day login streak'],
            365 => ['name' => 'Year of Gaming', 'description' => '365 day login streak'],
        ];

        if (isset($milestones[$streak])) {
            $user->badges()->firstOrCreate([
                'badge' => $milestones[$streak]['name'],
            ], [
                'description' => $milestones[$streak]['description'],
                'awarded_at' => now(),
            ]);
            
            // Bonus XP for milestone
            $this->reputationService->awardXP($user, $streak, 'streak_milestone');
        }
    }

    /**
     * Check posting streak
     */
    protected function checkPostingStreak(User $user): void
    {
        $lastPostDate = $user->posts()->latest()->first()?->created_at;
        $today = Carbon::today();
        
        if ($lastPostDate && $lastPostDate->isToday()) {
            return; // Already posted today
        }
        
        if ($lastPostDate && $lastPostDate->isYesterday()) {
            $user->profile->increment('posting_streak');
        } else {
            $user->profile->update(['posting_streak' => 1]);
        }
    }

    /**
     * Get seasonal leaderboard
     */
    public function getSeasonalLeaderboard(int $limit = 50)
    {
        $seasonStart = $this->getCurrentSeasonStart();
        
        return Cache::remember('leaderboard:seasonal:' . $seasonStart->format('Y-m-d'), 3600, function () use ($seasonStart, $limit) {
            return User::query()
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->select('users.*', 'user_profiles.xp', 'user_profiles.level', 'user_profiles.karma')
                ->where('users.created_at', '>=', $seasonStart)
                ->orWhereHas('posts', function ($query) use ($seasonStart) {
                    $query->where('created_at', '>=', $seasonStart);
                })
                ->withCount([
                    'posts as season_posts' => function ($query) use ($seasonStart) {
                        $query->where('created_at', '>=', $seasonStart);
                    }
                ])
                ->orderByDesc('user_profiles.xp')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get current season start date (quarterly)
     */
    protected function getCurrentSeasonStart(): Carbon
    {
        $now = now();
        $quarter = (int) ceil($now->month / 3);
        $seasonMonth = ($quarter - 1) * 3 + 1;
        
        return Carbon::create($now->year, $seasonMonth, 1)->startOfDay();
    }

    /**
     * Award achievement
     */
    public function awardAchievement(User $user, string $key, string $name, string $description): void
    {
        $achievement = $user->achievements()->firstOrCreate([
            'achievement_key' => $key,
        ], [
            'achievement_name' => $name,
            'achievement_description' => $description,
            'unlocked_at' => now(),
        ]);

        if ($achievement->wasRecentlyCreated) {
            // Award XP for achievement
            $this->reputationService->awardXP($user, 50, 'achievement_' . $key);
        }
    }
}
