<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\DatabaseNotification;

class RealtimeNotificationCreated implements ShouldBroadcastNow
{
    public function __construct(private readonly DatabaseNotification $notification)
    {
    }

    public function broadcastOn(): array
    {
        $privateChannel = str_replace('\\', '.', $this->notification->notifiable_type)
            .'.'.$this->notification->notifiable_id;

        return [
            new PrivateChannel($privateChannel),
            new Channel('global-notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    public function broadcastWith(): array
    {
        $data = $this->notification->data ?? [];

        return [
            'id' => $this->notification->id,
            'type' => $data['type'] ?? 'general',
            'title' => $data['title'] ?? '',
            'message' => $data['message'] ?? '',
            'url' => $data['url'] ?? '#',
            'read_at' => $this->notification->read_at,
            'created_at' => $this->notification->created_at?->diffForHumans(),
        ];
    }
}
