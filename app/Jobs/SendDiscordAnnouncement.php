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
     */
    public function handle(): void
    {
        if (! config('discord_channels.token') || ! config('discord_channels.guild_id')) {
            Log::warning('Discord bot not configured, skipping announcement sync');
            return;
        }

        try {
            // Create a Discord client instance for this job
            $discord = new Discord([
                'token' => config('discord_channels.token'),
                'intents' => Intents::getDefaultIntents(),
            ]);

            $loop = $discord->getLoop();

            // Use promises to handle async Discord operations
            $discord->on('init', function (Discord $discord) use ($loop) {
                $guildId = config('discord_channels.guild_id');

                $discord->guilds->fetch($guildId)->then(function ($guild) use ($discord, $loop) {
                    // Find the announcements channel
                    $announcementsChannel = $guild->channels->find(function (Channel $channel) {
                        return $channel->type !== Channel::TYPE_CATEGORY 
                            && strtolower($channel->name) === 'announcements';
                    });

                    if (! $announcementsChannel) {
                        Log::warning('Announcements channel not found in Discord guild');
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
                    $announcementsChannel->sendEmbed($embed)->then(function ($message) use ($loop) {
                        // Update announcement with Discord message ID
                        $this->announcement->update([
                            'discord_message_id' => $message->id,
                            'discord_channel_id' => $message->channel_id,
                        ]);

                        Log::info('Announcement sent to Discord', [
                            'announcement_id' => $this->announcement->id,
                            'message_id' => $message->id,
                        ]);

                        $loop->stop();
                    }, function ($error) use ($loop) {
                        Log::error('Failed to send announcement to Discord', [
                            'announcement_id' => $this->announcement->id,
                            'error' => $error,
                        ]);
                        $loop->stop();
                    });
                }, function ($error) use ($loop) {
                    Log::error('Failed to fetch Discord guild', [
                        'error' => $error,
                    ]);
                    $loop->stop();
                });
            });

            // Run the event loop to completion
            $loop->run();
        } catch (\Exception $e) {
            Log::error('Failed to send announcement to Discord', [
                'announcement_id' => $this->announcement->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
