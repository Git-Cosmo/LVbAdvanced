<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyChallengeCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_challenge_id',
        'points_earned',
        'completion_data',
        'completed_at',
    ];

    protected $casts = [
        'completion_data' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(DailyChallenge::class, 'daily_challenge_id');
    }
}
