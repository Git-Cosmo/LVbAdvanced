<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClanMember extends Model
{
    protected $fillable = [
        'clan_id',
        'user_id',
        'role',
        'joined_at',
        'stats',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'stats' => 'array',
    ];

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
