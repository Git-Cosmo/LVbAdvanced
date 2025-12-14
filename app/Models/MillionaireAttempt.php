<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MillionaireAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'millionaire_game_id',
        'current_question',
        'prize_won',
        'lifelines_used',
        'answers',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'lifelines_used' => 'array',
        'answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function millionaireGame()
    {
        return $this->belongsTo(MillionaireGame::class);
    }

    public function hasLifeline($lifeline)
    {
        return !in_array($lifeline, $this->lifelines_used ?? []);
    }

    public function useLifeline($lifeline)
    {
        $used = $this->lifelines_used ?? [];
        $used[] = $lifeline;
        $this->lifelines_used = $used;
        $this->save();
    }
}
