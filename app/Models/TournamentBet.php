<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentBet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tournament_id',
        'tournament_participant_id',
        'bet_type',
        'points_wagered',
        'odds',
        'status',
        'points_won',
    ];

    protected $casts = [
        'odds' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participant()
    {
        return $this->belongsTo(TournamentParticipant::class, 'tournament_participant_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSettled($query)
    {
        return $query->whereIn('status', ['won', 'lost', 'refunded']);
    }

    public function getPotentialWinningsAttribute()
    {
        return $this->points_wagered * $this->odds;
    }
}
