<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentParticipant extends Model
{
    protected $fillable = [
        'tournament_id',
        'user_id',
        'clan_id',
        'team_name',
        'seed',
        'status',
        'registered_at',
        'checked_in_at',
        'approved_at',
        'roster',
    ];

    protected function casts(): array
    {
        return [
            'roster' => 'array',
            'registered_at' => 'datetime',
            'checked_in_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class, 'participant1_id')
            ->orWhere('participant2_id', $this->id);
    }

    public function winsAsParticipant1()
    {
        return $this->hasMany(TournamentMatch::class, 'participant1_id')
            ->where('winner_id', $this->id);
    }

    public function winsAsParticipant2()
    {
        return $this->hasMany(TournamentMatch::class, 'participant2_id')
            ->where('winner_id', $this->id);
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->tournament->type === 'team') {
            return $this->team_name ?? $this->clan?->name ?? 'Team #'.$this->id;
        }

        return $this->user?->name ?? 'Player #'.$this->id;
    }

    public function isCheckedIn(): bool
    {
        return $this->status === 'checked_in';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved' || $this->status === 'checked_in';
    }
}
