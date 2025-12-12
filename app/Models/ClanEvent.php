<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClanEvent extends Model
{
    protected $fillable = [
        'clan_id',
        'title',
        'description',
        'event_type',
        'start_time',
        'end_time',
        'max_participants',
        'participants',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'participants' => 'array',
    ];

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
