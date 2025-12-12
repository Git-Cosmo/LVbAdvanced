<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerStat extends Model
{
    protected $fillable = [
        'user_id',
        'game_library_id',
        'stat_name',
        'stat_value',
        'stat_type',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
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
