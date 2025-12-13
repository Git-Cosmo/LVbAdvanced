<?php

namespace App\DiscordBot\Services;

use App\DiscordBot\Commands\AnnounceCommand;
use App\DiscordBot\Commands\ChuckNorrisCommand;
use App\DiscordBot\Commands\CoinFlipCommand;
use App\DiscordBot\Commands\CommandInterface;
use App\DiscordBot\Commands\DiceRollCommand;
use App\DiscordBot\Commands\EightBallCommand;
use App\DiscordBot\Commands\FeedbackCommand;
use App\DiscordBot\Commands\HelpCommand;
use App\DiscordBot\Commands\PingCommand;
use App\DiscordBot\Commands\ServerStatusCommand;
use App\DiscordBot\Commands\TriviaCommand;
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

    /**
     * @var CommandInterface[]
     */
    protected array $commands = [];

    public function __construct(Discord $discord, ChannelManager $channelManager)
    {
        $this->discord = $discord;
        $this->channelManager = $channelManager;
        
        // Register all commands
        $this->registerCommands();
    }

    /**
     * Register all available commands.
     */
    protected function registerCommands(): void
    {
        // Create command instances
        $announceCommand = new AnnounceCommand($this->discord, $this->channelManager);
        $pingCommand = new PingCommand();
        $helpCommand = new HelpCommand($this->discord);
        $chuckNorrisCommand = new ChuckNorrisCommand();
        $diceRollCommand = new DiceRollCommand();
        $coinFlipCommand = new CoinFlipCommand();
        $eightBallCommand = new EightBallCommand();
        $triviaCommand = new TriviaCommand($this->discord);
        $serverStatusCommand = new ServerStatusCommand($this->discord);
        $feedbackCommand = new FeedbackCommand();

        // Register commands
        $this->commands = [
            $announceCommand->getName() => $announceCommand,
            $pingCommand->getName() => $pingCommand,
            $helpCommand->getName() => $helpCommand,
            $chuckNorrisCommand->getName() => $chuckNorrisCommand,
            $diceRollCommand->getName() => $diceRollCommand,
            $coinFlipCommand->getName() => $coinFlipCommand,
            $eightBallCommand->getName() => $eightBallCommand,
            $triviaCommand->getName() => $triviaCommand,
            $serverStatusCommand->getName() => $serverStatusCommand,
            $feedbackCommand->getName() => $feedbackCommand,
        ];

        // Set available commands for help command
        $helpCommand->setCommands($this->commands);
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
        $commandName = strtolower(substr($parts[0], 1)); // Remove the !
        $args = $parts[1] ?? '';

        // Execute the command if it exists
        if (isset($this->commands[$commandName])) {
            $this->commands[$commandName]->execute($message, $args);
        }
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

        $announcementsChannel->sendEmbed($embed)->then(function (Message $message) use ($announcement) {
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
}
