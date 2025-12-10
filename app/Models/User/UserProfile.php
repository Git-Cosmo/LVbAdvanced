<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'avatar',
        'cover_image',
        'about_me',
        'location',
        'website',
        'steam_id',
        'discord_id',
        'battlenet_id',
        'xbox_gamertag',
        'psn_id',
        'xp',
        'level',
        'karma',
        'user_title',
        'custom_fields',
        'privacy_settings',
        'followers_count',
        'following_count',
        'last_activity_at',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'privacy_settings' => 'array',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Add XP to the user and level up if needed.
     */
    public function addXp(int $amount): void
    {
        $this->xp += $amount;
        $this->checkLevelUp();
        $this->save();
    }

    /**
     * Check if user should level up.
     */
    protected function checkLevelUp(): void
    {
        $requiredXp = $this->level * 1000; // Simple formula
        while ($this->xp >= $requiredXp) {
            $this->level++;
            $this->xp -= $requiredXp;
            $requiredXp = $this->level * 1000; // Recalculate for next level
        }
    }
}
