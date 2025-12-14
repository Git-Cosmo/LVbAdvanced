<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoguessrAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'geoguessr_game_id',
        'total_score',
        'rounds_completed',
        'round_data',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'round_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function geoguessrGame()
    {
        return $this->belongsTo(GeoguessrGame::class);
    }
}
