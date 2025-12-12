<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriviaAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trivia_game_id',
        'score',
        'correct_answers',
        'total_questions',
        'time_taken',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function triviaGame()
    {
        return $this->belongsTo(TriviaGame::class);
    }

    public function getAccuracyAttribute()
    {
        return $this->total_questions > 0
            ? round(($this->correct_answers / $this->total_questions) * 100, 1)
            : 0;
    }
}
