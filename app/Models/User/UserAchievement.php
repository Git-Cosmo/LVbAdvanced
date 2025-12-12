<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserAchievement extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'points',
        'criteria',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'criteria' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the users who have this achievement.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'achievement_user')
            ->withTimestamps()
            ->withPivot(['progress', 'is_unlocked', 'unlocked_at']);
    }

    /**
     * Check if achievement is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get formatted unlocked at date from pivot.
     */
    public function getFormattedUnlockedAtAttribute(): ?string
    {
        if (!$this->pivot || !$this->pivot->unlocked_at) {
            return null;
        }

        return \Carbon\Carbon::parse($this->pivot->unlocked_at)->diffForHumans();
    }
}
