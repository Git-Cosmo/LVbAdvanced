<?php

namespace App\Jobs;

use App\Models\Announcement;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Embed\Embed;
use Discord\WebSockets\Intents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendDiscordAnnouncement implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Announcement $announcement)
    {
        //
    }

    /**
     * Execute the job.
     * 
     * Note: This job creates a temporary Discord client for sending announcements.
     * For better performance, consider using the long-running bot service via Reverb/WebSocket.
     */
    public function handle(): void
    {
        if (! config('discord_channels.token') || ! config('discord_channels.guild_id')) {
            Log::warning('Discord bot not configured, skipping announcement sync');
            return;
        }

        try {
            // Create a Discord client instance for this job
            // Include MESSAGE_CONTENT intent for full functionality
            $discord = new Discord([
                'token' => config('discord_channels.token'),
                'intents' => Intents::getDefaultIntents() | Intents::MESSAGE_CONTENT,
            ]);

            $loop = $discord->getLoop();
            $sentSuccessfully = false;

            // Use promises to handle async Discord operations
            $discord->on('init', function (Discord $discord) use ($loop, &$sentSuccessfully) {
                $guildId = config('discord_channels.guild_id');

                $discord->guilds->fetch($guildId)->then(function ($guild) use ($discord, $loop, &$sentSuccessfully) {
                    // Find the announcements channel
                    $announcementsChannel = $guild->channels->find(function (Channel $channel) {
                        return $channel->type !== Channel::TYPE_CATEGORY 
                            && strtolower($channel->name) === 'announcements';
                    });

                    if (! $announcementsChannel) {
                        Log::warning('Announcements channel not found in Discord guild', [
                            'guild_id' => $guild->id,
                            'guild_name' => $guild->name,
                        ]);
                        $loop->stop();
                        return;
                    }

                    // Create the embed
                    $embed = new Embed($discord);
                    $embed
                        ->setTitle('📢 ' . $this->announcement->title)
                        ->setDescription($this->announcement->message)
                        ->setColor('#5865F2')
                        ->setTimestamp($this->announcement->published_at?->timestamp);

                    if ($this->announcement->user) {
                        $embed->setFooter('Posted by ' . $this->announcement->user->name);
                    }

                    // Send the embed
                    $announcementsChannel->sendEmbed($embed)->then(function ($message) use ($loop, &$sentSuccessfully) {
                        // Update announcement with Discord message ID
                        $this->announcement->update([
                            'discord_message_id' => $message->id,
                            'discord_channel_id' => $message->channel_id,
                        ]);

                        Log::info('Announcement sent to Discord', [
                            'announcement_id' => $this->announcement->id,
                            'message_id' => $message->id,
                        ]);

                        $sentSuccessfully = true;
                        $loop->stop();
                    }, function ($error) use ($loop) {
                        Log::error('Failed to send announcement to Discord', [
                            'announcement_id' => $this->announcement->id,
                            'error' => (string) $error,
                        ]);
                        $loop->stop();
                    });
                }, function ($error) use ($loop) {
                    Log::error('Failed to fetch Discord guild', [
                        'guild_id' => config('discord_channels.guild_id'),
                        'error' => (string) $error,
                    ]);
                    $loop->stop();
                });
            });

            $discord->on('error', function ($error) use ($loop) {
                Log::error('Discord client error in announcement job', [
                    'announcement_id' => $this->announcement->id,
                    'error' => (string) $error,
                ]);
                $loop->stop();
            });

            // Run the event loop to completion with timeout
            $timeoutTimer = $loop->addTimer(30, function () use ($loop, &$sentSuccessfully) {
                if (!$sentSuccessfully) {
                    Log::warning('Discord announcement job timed out', [
                        'announcement_id' => $this->announcement->id,
                    ]);
                }
                $loop->stop();
            });

            $loop->run();
            
            // Cancel timeout if loop completed
            $loop->cancelTimer($timeoutTimer);

        } catch (\Exception $e) {
            Log::error('Failed to send announcement to Discord', [
                'announcement_id' => $this->announcement->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
