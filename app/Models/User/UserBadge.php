<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserBadge extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'points',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users who have this badge.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'badge_user')
            ->withTimestamps()
            ->withPivot('awarded_at');
    }

    /**
     * Get formatted awarded at date from pivot.
     */
    public function getFormattedAwardedAtAttribute(): ?string
    {
        if (! $this->pivot || ! $this->pivot->awarded_at) {
            return null;
        }

        return \Carbon\Carbon::parse($this->pivot->awarded_at)->diffForHumans();
    }
}
