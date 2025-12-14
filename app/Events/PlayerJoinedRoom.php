<?php

namespace App\Events;

use App\Models\GameRoom;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerJoinedRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameRoom;
    public $user;

    public function __construct(GameRoom $gameRoom, User $user)
    {
        $this->gameRoom = $gameRoom;
        $this->user = $user;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('game-room.' . $this->gameRoom->code);
    }

    public function broadcastAs(): string
    {
        return 'player.joined';
    }

    public function broadcastWith(): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'players_count' => $this->gameRoom->players()->count(),
        ];
    }
}
