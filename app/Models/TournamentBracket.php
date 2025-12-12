<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TournamentBracket extends Model
{
    protected $fillable = [
        'tournament_id',
        'bracket_type',
        'bracket_data',
    ];

    protected function casts(): array
    {
        return [
            'bracket_data' => 'array',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
