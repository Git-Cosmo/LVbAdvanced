<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
use App\Jobs\SendDiscordAnnouncement;
use Illuminate\Support\Facades\Log;

class SendAnnouncementToDiscord
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AnnouncementCreated $event): void
    {
        // Only send to Discord if the announcement originated from the website
        // and the Discord bot is configured
        if ($event->announcement->isFromWebsite() && config('discord_channels.token')) {
            try {
                // Dispatch a job to send the announcement to Discord
                // This allows the announcement to be sent asynchronously without blocking
                // and provides retry capability if the Discord API is temporarily unavailable
                SendDiscordAnnouncement::dispatch($event->announcement);

                Log::info('Announcement queued for Discord sync', [
                    'announcement_id' => $event->announcement->id,
                    'title' => $event->announcement->title,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to queue announcement for Discord', [
                    'announcement_id' => $event->announcement->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
