<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriviaQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'trivia_game_id',
        'question',
        'options',
        'correct_answer_index',
        'explanation',
        'points',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function triviaGame()
    {
        return $this->belongsTo(TriviaGame::class);
    }

    public function getCorrectAnswerAttribute()
    {
        return $this->options[$this->correct_answer_index] ?? null;
    }
}
