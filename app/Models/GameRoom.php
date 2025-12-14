<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GameRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'game_type',
        'game_id',
        'host_user_id',
        'max_players',
        'status',
        'settings',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->code)) {
                // Generate unique code
                do {
                    $code = strtoupper(Str::random(6));
                } while (self::where('code', $code)->exists());
                
                $room->code = $code;
            }
        });
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_user_id');
    }

    public function players()
    {
        return $this->hasMany(GameRoomPlayer::class);
    }

    public function game()
    {
        return match ($this->game_type) {
            'millionaire' => $this->belongsTo(MillionaireGame::class, 'game_id'),
            'geoguessr' => $this->belongsTo(GeoguessrGame::class, 'game_id'),
            'trivia' => $this->belongsTo(TriviaGame::class, 'game_id'),
            default => null,
        };
    }

    public function isFull()
    {
        return $this->players()->count() >= $this->max_players;
    }

    public function canJoin($user)
    {
        return !$this->isFull() && 
               $this->status === 'waiting' &&
               !$this->players()->where('user_id', $user->id)->exists();
    }
}
