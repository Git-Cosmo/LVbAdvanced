<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBan extends Model
{
    protected $fillable = [
        'user_id',
        'banned_by',
        'reason',
        'type',
        'expires_at',
        'ip_address',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the banned user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the moderator who issued the ban.
     */
    public function bannedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'banned_by');
    }

    /**
     * Check if ban is still active.
     */
    public function isActive(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->type === 'permanent') {
            return true;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if ban is permanent.
     */
    public function isPermanent(): bool
    {
        return $this->type === 'permanent';
    }
}
