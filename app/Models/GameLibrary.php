<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameLibrary extends Model
{
    protected $fillable = [
        'user_id',
        'integration_id',
        'game_id',
        'game_name',
        'platform',
        'image_url',
        'playtime_minutes',
        'added_at',
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function integration(): BelongsTo
    {
        return $this->belongsTo(GameIntegration::class, 'integration_id');
    }

    public function recentlyPlayed(): HasMany
    {
        return $this->hasMany(RecentlyPlayed::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(PlayerStat::class);
    }
}
