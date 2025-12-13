<?php

namespace App\DiscordBot\Services;

use Discord\Discord;
use Discord\WebSockets\Intents;
use Illuminate\Support\Facades\Cache;
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
                'id' => $discord->user->id,
            ]);

            // Initialize channels on startup
            $this->channelManager->provisionChannels();

            // Register message handler
            $this->messageHandler->registerHandlers();

            // Set initial heartbeat
            $this->updateHeartbeat();

            // Set up periodic heartbeat (every 30 seconds)
            $discord->getLoop()->addPeriodicTimer(30, function () {
                $this->updateHeartbeat();
            });

            Log::info('Discord bot fully initialized', [
                'guilds_count' => $discord->guilds->count(),
            ]);
        });

        $this->discord->on('error', function ($error) {
            Log::error('Discord bot error', [
                'error' => (string) $error,
                'type' => get_class($error),
            ]);
        });

        // Handle reconnection events
        $this->discord->on('reconnecting', function () {
            Log::warning('Discord bot is reconnecting...');
        });

        $this->discord->on('reconnected', function () {
            Log::info('Discord bot reconnected successfully');
        });

        // Handle disconnection
        $this->discord->on('closed', function ($op, $reason) {
            Log::warning('Discord bot connection closed', [
                'op' => $op,
                'reason' => $reason,
            ]);
        });

        Log::info('Starting Discord bot...', [
            'token_configured' => !empty(config('discord_channels.token')),
            'guild_id' => config('discord_channels.guild_id'),
        ]);
        
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

    /**
     * Update heartbeat in cache to indicate bot is online.
     */
    protected function updateHeartbeat(): void
    {
        Cache::put('discord_bot_heartbeat', true, 90); // 90 seconds TTL (3x the heartbeat interval)
        Cache::put('discord_bot_last_heartbeat', now()->toIso8601String(), 3600); // Keep for 1 hour
    }
}
