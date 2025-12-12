<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecentlyPlayed extends Model
{
    protected $table = 'recently_played';

    protected $fillable = [
        'user_id',
        'game_library_id',
        'last_played_at',
        'session_minutes',
    ];

    protected $casts = [
        'last_played_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameLibrary(): BelongsTo
    {
        return $this->belongsTo(GameLibrary::class);
    }
}
