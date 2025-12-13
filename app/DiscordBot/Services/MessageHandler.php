<?php

namespace App\DiscordBot\Services;

use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Illuminate\Support\Facades\Log;

class MessageHandler
{
    protected Discord $discord;

    protected ChannelManager $channelManager;

    public function __construct(Discord $discord, ChannelManager $channelManager)
    {
        $this->discord = $discord;
        $this->channelManager = $channelManager;
    }

    /**
     * Register message handlers.
     */
    public function registerHandlers(): void
    {
        $this->discord->on('message', function (Message $message) {
            // Ignore bot messages
            if ($message->author->bot ?? false) {
                return;
            }

            // Handle commands
            $this->handleCommands($message);
        });

        Log::info('Message handlers registered');
    }

    /**
     * Handle bot commands.
     */
    protected function handleCommands(Message $message): void
    {
        $content = trim($message->content);

        // Check if message starts with !
        if (! str_starts_with($content, '!')) {
            return;
        }

        // Parse command and arguments
        $parts = explode(' ', $content, 2);
        $command = strtolower(substr($parts[0], 1)); // Remove the !
        $args = $parts[1] ?? '';

        // Handle different commands
        match ($command) {
            'announce' => $this->handleAnnounceCommand($message, $args),
            'ping' => $this->handlePingCommand($message),
            'help' => $this->handleHelpCommand($message),
            default => null,
        };
    }

    /**
     * Handle the !announce command.
     */
    protected function handleAnnounceCommand(Message $message, string $content): void
    {
        // Check permissions
        if (! $this->hasPermission($message, 'announce')) {
            $message->reply('❌ You do not have permission to use this command.');

            return;
        }

        if (empty($content)) {
            $message->reply('❌ Please provide a message to announce. Usage: `!announce <message>`');

            return;
        }

        // Extract title and message
        $lines = explode("\n", $content, 2);
        $title = $lines[0];
        $messageText = $lines[1] ?? $title;

        // Create announcement in database
        $announcement = Announcement::create([
            'title' => $title,
            'message' => $messageText,
            'source' => 'discord',
            'discord_channel_id' => $message->channel_id,
            'published_at' => now(),
            'metadata' => [
                'author_id' => $message->author->id,
                'author_username' => $message->author->username,
                'guild_id' => $message->guild_id,
            ],
        ]);

        // Post to announcements channel
        $announcementsChannel = $this->channelManager->getAnnouncementsChannel();

        if ($announcementsChannel) {
            $embed = $this->createAnnouncementEmbed($announcement, $message);

            $announcementsChannel->sendEmbed($embed)->done(function (Message $sentMessage) use ($announcement) {
                // Update announcement with Discord message ID after successful post
                $announcement->update([
                    'discord_message_id' => $sentMessage->id,
                ]);

                Log::info('Announcement posted to Discord', [
                    'announcement_id' => $announcement->id,
                    'message_id' => $sentMessage->id,
                ]);
            });
        }

        // Broadcast to website via Reverb
        event(new AnnouncementCreated($announcement));

        // Confirm to user
        $message->reply('✅ Announcement created and broadcasted!');

        Log::info('Announcement created from Discord', [
            'announcement_id' => $announcement->id,
            'author' => $message->author->username,
        ]);
    }

    /**
     * Handle the !ping command.
     */
    protected function handlePingCommand(Message $message): void
    {
        $message->reply('🏓 Pong!');
    }

    /**
     * Handle the !help command.
     */
    protected function handleHelpCommand(Message $message): void
    {
        $embed = new Embed($this->discord);
        $embed
            ->setTitle('🤖 Bot Commands')
            ->setDescription('Here are the available commands:')
            ->addFieldValues('!announce <message>', 'Create an announcement (Admin/Moderator only)')
            ->addFieldValues('!ping', 'Check if the bot is responsive')
            ->addFieldValues('!help', 'Show this help message')
            ->setColor('#5865F2')
            ->setTimestamp();

        $message->channel->sendEmbed($embed);
    }

    /**
     * Create an embed for announcements.
     */
    protected function createAnnouncementEmbed(Announcement $announcement, ?Message $originalMessage = null): Embed
    {
        $embed = new Embed($this->discord);
        $embed
            ->setTitle('📢 ' . $announcement->title)
            ->setDescription($announcement->message)
            ->setColor('#5865F2')
            ->setTimestamp($announcement->published_at?->timestamp);

        if ($originalMessage) {
            $embed->setFooter('Posted by ' . $originalMessage->author->username);
        }

        return $embed;
    }

    /**
     * Send an announcement to Discord from the website.
     */
    public function sendAnnouncementToDiscord(Announcement $announcement): void
    {
        $announcementsChannel = $this->channelManager->getAnnouncementsChannel();

        if (! $announcementsChannel) {
            Log::warning('Announcements channel not found');

            return;
        }

        $embed = $this->createAnnouncementEmbed($announcement);

        $announcementsChannel->sendEmbed($embed)->done(function (Message $message) use ($announcement) {
            // Update announcement with Discord message ID
            $announcement->update([
                'discord_message_id' => $message->id,
                'discord_channel_id' => $message->channel_id,
            ]);

            Log::info('Announcement sent to Discord', [
                'announcement_id' => $announcement->id,
                'message_id' => $message->id,
            ]);
        }, function ($error) use ($announcement) {
            Log::error('Failed to send announcement to Discord', [
                'announcement_id' => $announcement->id,
                'error' => $error,
            ]);
        });
    }

    /**
     * Check if a user has permission to use a command.
     */
    protected function hasPermission(Message $message, string $command): bool
    {
        $allowedRoles = config("discord_channels.permissions.{$command}", []);

        if (empty($allowedRoles)) {
            return true; // No restrictions
        }

        // Check if user has any of the allowed roles
        $member = $message->member;
        if (! $member) {
            return false;
        }

        foreach ($member->roles as $role) {
            if (in_array(strtolower($role->name), array_map('strtolower', $allowedRoles))) {
                return true;
            }
        }

        return false;
    }
}
