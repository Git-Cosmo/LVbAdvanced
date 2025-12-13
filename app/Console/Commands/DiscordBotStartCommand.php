<?php

namespace App\Console\Commands;

use App\DiscordBot\Services\DiscordBotService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DiscordBotStartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discordbot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Discord bot process';

    /**
     * Execute the console command.
     */
    public function handle(DiscordBotService $botService): int
    {
        if (! config('discord_channels.token')) {
            $this->error('Discord bot token is not configured. Please set DISCORD_BOT_TOKEN in your .env file.');

            return self::FAILURE;
        }

        if (! config('discord_channels.guild_id')) {
            $this->error('Discord guild ID is not configured. Please set DISCORD_GUILD_ID in your .env file.');

            return self::FAILURE;
        }

        $this->info('🚀 Starting Discord bot...');
        $this->info('Press Ctrl+C to stop the bot.');

        try {
            $botService->start();
        } catch (\Exception $e) {
            $this->error('Failed to start Discord bot: ' . $e->getMessage());
            Log::error('Discord bot failed to start', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
