<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentCheckIn extends Model
{
    protected $fillable = [
        'tournament_id',
        'participant_id',
        'checked_in_at',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'checked_in_at' => 'datetime',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(TournamentParticipant::class, 'participant_id');
    }
}
