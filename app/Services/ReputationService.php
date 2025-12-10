<?php

namespace App\Services;

use App\Models\User;
use App\Models\Forum\ForumReaction;
use Illuminate\Support\Facades\DB;

class ReputationService
{
    /**
     * Award XP to a user
     */
    public function awardXP(User $user, int $amount, string $reason = ''): void
    {
        $user->profile->increment('xp', $amount);
        
        // Check for level up
        $this->checkLevelUp($user);
        
        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties(['xp' => $amount, 'reason' => $reason])
            ->log('xp_awarded');
    }

    /**
     * Check and update user level based on XP
     */
    public function checkLevelUp(User $user): bool
    {
        $currentLevel = $user->profile->level;
        $newLevel = $this->calculateLevel($user->profile->xp);
        
        if ($newLevel > $currentLevel) {
            $user->profile->update(['level' => $newLevel]);
            
            // Award level up badge/achievement
            $this->awardLevelBadge($user, $newLevel);
            
            activity()
                ->causedBy($user)
                ->performedOn($user)
                ->withProperties(['old_level' => $currentLevel, 'new_level' => $newLevel])
                ->log('level_up');
            
            return true;
        }
        
        return false;
    }

    /**
     * Calculate level from XP
     */
    public function calculateLevel(int $xp): int
    {
        // Level formula: Level = floor(sqrt(XP / 100))
        return max(1, (int) floor(sqrt($xp / 100)));
    }

    /**
     * Calculate XP needed for next level
     */
    public function xpForNextLevel(int $currentLevel): int
    {
        return ($currentLevel + 1) ** 2 * 100;
    }

    /**
     * Award karma based on reactions received on user's posts
     */
    public function updateKarma(User $user): void
    {
        // Count likes received on posts by this user
        $karma = ForumReaction::where('reactable_type', \App\Models\Forum\ForumPost::class)
            ->where('type', 'like')
            ->whereIn('reactable_id', function($query) use ($user) {
                $query->select('id')
                      ->from('forum_posts')
                      ->where('user_id', $user->id);
            })
            ->count();
        
        $user->profile->update(['karma' => $karma]);
    }

    /**
     * Award badge for level achievement
     */
    protected function awardLevelBadge(User $user, int $level): void
    {
        $badges = [
            5 => ['name' => 'Rising Star', 'description' => 'Reached level 5'],
            10 => ['name' => 'Veteran Gamer', 'description' => 'Reached level 10'],
            25 => ['name' => 'Elite Player', 'description' => 'Reached level 25'],
            50 => ['name' => 'Legendary', 'description' => 'Reached level 50'],
            100 => ['name' => 'Godlike', 'description' => 'Reached level 100'],
        ];
        
        if (isset($badges[$level])) {
            // Find or create the badge
            $badge = \App\Models\User\UserBadge::firstOrCreate([
                'badge' => $badges[$level]['name'],
            ], [
                'description' => $badges[$level]['description'],
            ]);
            
            // Attach badge to user if not already attached
            if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge->id, ['awarded_at' => now()]);
            }
        }
    }

    /**
     * Get leaderboard
     */
    public function getLeaderboard(string $type = 'xp', string $period = 'all-time', int $limit = 10)
    {
        $query = User::query()
            ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->select('users.*');
        
        switch ($type) {
            case 'karma':
                $query->orderBy('user_profiles.karma', 'desc');
                break;
            case 'posts':
                $query->withCount('posts')->orderBy('posts_count', 'desc');
                break;
            case 'xp':
            default:
                $query->orderBy('user_profiles.xp', 'desc');
                break;
        }
        
        // Apply period filter if not all-time
        if ($period !== 'all-time') {
            $date = match($period) {
                'daily' => now()->subDay(),
                'weekly' => now()->subWeek(),
                'monthly' => now()->subMonth(),
                'seasonal' => now()->subMonths(3),
                default => now()->subDay(),
            };
            
            $query->where('users.created_at', '>=', $date);
        }
        
        return $query->limit($limit)->get();
    }
}
