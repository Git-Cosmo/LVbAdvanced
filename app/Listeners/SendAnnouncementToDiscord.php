<?php

namespace App\Listeners;

use App\DiscordBot\Services\MessageHandler;
use App\Events\AnnouncementCreated;
use Illuminate\Support\Facades\Log;

class SendAnnouncementToDiscord
{
    /**
     * Create the event listener.
     */
    public function __construct(protected MessageHandler $messageHandler)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnnouncementCreated $event): void
    {
        // Only send to Discord if the announcement originated from the website
        if ($event->announcement->isFromWebsite()) {
            try {
                $this->messageHandler->sendAnnouncementToDiscord($event->announcement);
            } catch (\Exception $e) {
                Log::error('Failed to send announcement to Discord', [
                    'announcement_id' => $event->announcement->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
