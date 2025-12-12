<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TournamentMatch extends Model
{
    protected $fillable = [
        'tournament_id',
        'round',
        'match_number',
        'participant1_id',
        'participant2_id',
        'winner_id',
        'participant1_score',
        'participant2_score',
        'status',
        'scheduled_at',
        'started_at',
        'completed_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participant1(): BelongsTo
    {
        return $this->belongsTo(TournamentParticipant::class, 'participant1_id');
    }

    public function participant2(): BelongsTo
    {
        return $this->belongsTo(TournamentParticipant::class, 'participant2_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(TournamentParticipant::class, 'winner_id');
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(TournamentDispute::class, 'match_id');
    }

    public function isReady(): bool
    {
        return $this->participant1_id && $this->participant2_id;
    }

    public function isBye(): bool
    {
        return ($this->participant1_id && ! $this->participant2_id) ||
               (! $this->participant1_id && $this->participant2_id);
    }
}
