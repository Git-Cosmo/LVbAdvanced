<?php

namespace App\DiscordBot\Commands;

use App\DiscordBot\Services\ChannelManager;
use App\DiscordBot\Services\RateLimiter;
use App\Events\AnnouncementCreated;
use App\Models\Announcement;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Illuminate\Support\Facades\Log;

class AnnounceCommand extends BaseCommand
{
    public function __construct(
        protected Discord $discord,
        protected ChannelManager $channelManager,
        protected ?RateLimiter $rateLimiter = null
    ) {
        $this->rateLimiter = $rateLimiter ?? new RateLimiter();
    }

    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'announce';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Create an announcement (Admin/Moderator only)';
    }

    /**
     * Get the required roles for this command.
     */
    protected function getRequiredRoles(): array
    {
        return config('discord_channels.permissions.announce', ['admin', 'moderator']);
    }

    /**
     * Execute the announce command.
     */
    public function execute(Message $message, string $args): void
    {
        // Check permissions
        if (! $this->hasPermission($message)) {
            $message->reply('❌ You do not have permission to use this command.');
            return;
        }

        // Check rate limiting (3 announcements per 5 minutes per user)
        $userId = $message->author->id;
        if ($this->rateLimiter->tooManyAttempts($userId, 'announce', 3, 300)) {
            $message->reply('⏱️ You are creating announcements too quickly. Please wait a few minutes before trying again.');
            Log::warning('User hit rate limit for announce command', [
                'user_id' => $userId,
                'username' => $message->author->username,
            ]);
            return;
        }

        if (empty($args)) {
            $message->reply('❌ Please provide a message to announce. Usage: `!announce <title>\n<message>`');
            return;
        }

        // Extract title and message
        $lines = explode("\n", $args, 2);
        $title = $lines[0];

        // Require both title and message
        if (! isset($lines[1]) || trim($lines[1]) === '') {
            $message->reply('❌ Please provide both a title and a message, separated by a newline. Usage: `!announce <title>\n<message>`');
            return;
        }

        $messageText = $lines[1];

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

            $announcementsChannel->sendEmbed($embed)->then(function (Message $sentMessage) use ($announcement) {
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

        // Increment rate limit counter
        $this->rateLimiter->hit($userId, 'announce', 300);

        // Confirm to user
        $message->reply('✅ Announcement created and broadcasted!');

        Log::info('Announcement created from Discord', [
            'announcement_id' => $announcement->id,
            'author' => $message->author->username,
            'user_id' => $userId,
        ]);
    }

    /**
     * Create an embed for the announcement.
     */
    protected function createAnnouncementEmbed(Announcement $announcement, Message $originalMessage): Embed
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
}
