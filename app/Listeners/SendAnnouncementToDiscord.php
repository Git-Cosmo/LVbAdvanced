<?php

namespace App\Listeners;

use App\Events\AnnouncementCreated;
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
                // Note: This requires the Discord bot to be running
                // The actual sending happens through the bot's event listener
                // This just logs the intent - actual implementation would use
                // a queue job or bot API when bot is active
                Log::info('Announcement ready for Discord sync', [
                    'announcement_id' => $event->announcement->id,
                    'title' => $event->announcement->title,
                ]);

                // TODO: In production, use a queue job to send to Discord API
                // or trigger bot webhook if bot supports it
            } catch (\Exception $e) {
                Log::error('Failed to prepare announcement for Discord', [
                    'announcement_id' => $event->announcement->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
