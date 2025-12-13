<?php

namespace App\DiscordBot\Services;

use Discord\Discord;
use Discord\WebSockets\Intents;
use Illuminate\Support\Facades\Log;

class DiscordBotService
{
    protected Discord $discord;

    protected ChannelManager $channelManager;

    protected MessageHandler $messageHandler;

    public function __construct()
    {
        $this->discord = new Discord([
            'token' => config('discord_channels.token'),
            'intents' => Intents::getDefaultIntents() | Intents::MESSAGE_CONTENT | Intents::GUILDS | Intents::GUILD_MESSAGES,
        ]);

        $this->channelManager = new ChannelManager($this->discord);
        $this->messageHandler = new MessageHandler($this->discord, $this->channelManager);
    }

    /**
     * Start the Discord bot.
     */
    public function start(): void
    {
        $this->discord->on('init', function (Discord $discord) {
            Log::info('Discord bot is ready!', [
                'username' => $discord->user->username,
                'discriminator' => $discord->user->discriminator,
            ]);

            // Initialize channels on startup
            $this->channelManager->provisionChannels();

            // Register message handler
            $this->messageHandler->registerHandlers();

            Log::info('Discord bot fully initialized');
        });

        $this->discord->on('error', function ($error) {
            Log::error('Discord bot error', ['error' => $error]);
        });

        Log::info('Starting Discord bot...');
        $this->discord->run();
    }

    /**
     * Get the Discord client instance.
     */
    public function getDiscord(): Discord
    {
        return $this->discord;
    }

    /**
     * Get the channel manager instance.
     */
    public function getChannelManager(): ChannelManager
    {
        return $this->channelManager;
    }

    /**
     * Get the message handler instance.
     */
    public function getMessageHandler(): MessageHandler
    {
        return $this->messageHandler;
    }
}
