<?php

namespace App\DiscordBot\Commands;

use App\Models\GameServer;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Discord;
use Illuminate\Support\Facades\Log;

class ServerStatusCommand extends BaseCommand
{
    protected Discord $discord;

    /**
     * Create a new server status command instance.
     *
     * @param Discord $discord The Discord client instance for creating embeds
     */
    public function __construct(Discord $discord)
    {
        $this->discord = $discord;
    }

    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'servers';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Show game server status from the website';
    }

    /**
     * Execute the server status command.
     */
    public function execute(Message $message, string $args): void
    {
        try {
            $servers = GameServer::where('is_active', true)
                ->orderBy('display_order')
                ->take(10)
                ->get();

            if ($servers->isEmpty()) {
                $message->reply('📡 No active game servers found.');
                return;
            }

            $embed = new Embed($this->discord);
            $embed->setTitle('🎮 Game Server Status');
            $embed->setColor('#5865F2');
            $embed->setTimestamp();

            foreach ($servers as $server) {
                $statusEmoji = match ($server->status) {
                    'online' => '🟢',
                    'offline' => '🔴',
                    'maintenance' => '🟡',
                    'coming_soon' => '🔵',
                    default => '⚪',
                };

                $playerInfo = $server->max_players 
                    ? " ({$server->current_players}/{$server->max_players} players)"
                    : '';

                $connectInfo = $server->ip_address && $server->port
                    ? "\n📍 `{$server->ip_address}:{$server->port}`"
                    : ($server->connect_url ? "\n🔗 {$server->connect_url}" : '');

                $value = "{$statusEmoji} **Status:** " . ucfirst($server->status) . $playerInfo . $connectInfo;

                $embed->addFieldValues($server->name, $value, false);
            }

            $embed->setFooter('Live server data from FPSociety website');

            $message->channel->sendEmbed($embed);

            Log::info('Server status command executed', [
                'user' => $message->author->username,
                'servers_count' => $servers->count(),
            ]);
        } catch (\Exception $e) {
            $message->reply('❌ Failed to fetch server status. Please try again later.');
            Log::error('Server status command failed', [
                'error' => $e->getMessage(),
                'user' => $message->author->username,
            ]);
        }
    }
}
