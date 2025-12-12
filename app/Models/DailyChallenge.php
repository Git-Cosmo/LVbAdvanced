<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DailyChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'challenge_type',
        'requirements',
        'points_reward',
        'badge_reward',
        'valid_date',
        'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'badge_reward' => 'array',
        'valid_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function completions()
    {
        return $this->hasMany(DailyChallengeCompletion::class);
    }

    public function scopeToday($query)
    {
        return $query->where('valid_date', Carbon::today())
            ->where('is_active', true);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('valid_date', $date)
            ->where('is_active', true);
    }

    public function isCompletedByUser($userId)
    {
        return $this->completions()
            ->where('user_id', $userId)
            ->exists();
    }
}
