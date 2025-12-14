<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MillionaireQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'millionaire_game_id',
        'question',
        'options',
        'correct_answer_index',
        'difficulty_level',
        'prize_amount',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer_index' => 'integer',
    ];

    public function millionaireGame()
    {
        return $this->belongsTo(MillionaireGame::class);
    }
}
