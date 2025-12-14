<?php

namespace App\Events;

use App\Models\GameRoom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameRoomUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameRoom;
    public $action;
    public $data;

    public function __construct(GameRoom $gameRoom, string $action, array $data = [])
    {
        $this->gameRoom = $gameRoom;
        $this->action = $action;
        $this->data = $data;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('game-room.' . $this->gameRoom->code);
    }

    public function broadcastAs(): string
    {
        return 'room.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'room' => [
                'code' => $this->gameRoom->code,
                'status' => $this->gameRoom->status,
                'players_count' => $this->gameRoom->players()->count(),
            ],
            'data' => $this->data,
        ];
    }
}
