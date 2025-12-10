<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheapSharkSyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'run_type',
        'stores_synced',
        'games_synced',
        'deals_synced',
        'message',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
