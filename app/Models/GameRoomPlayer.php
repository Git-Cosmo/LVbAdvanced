<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRoomPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_room_id',
        'user_id',
        'score',
        'rank',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function gameRoom()
    {
        return $this->belongsTo(GameRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
