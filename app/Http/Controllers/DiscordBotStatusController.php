<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class DiscordBotStatusController extends Controller
{
    /**
     * Get Discord bot status.
     */
    public function status(): JsonResponse
    {
        // Check if the bot is running by looking for a heartbeat file or cache
        $isOnline = Cache::has('discord_bot_heartbeat');
        $lastHeartbeat = Cache::get('discord_bot_last_heartbeat');
        
        // Alternatively, check if the bot process is running (Linux/Unix)
        if (!$isOnline && function_exists('exec')) {
            $output = [];
            exec('pgrep -f "discordbot:start" 2>&1', $output, $returnCode);
            $isOnline = $returnCode === 0 && !empty($output);
        }

        return response()->json([
            'status' => $isOnline ? 'online' : 'offline',
            'online' => $isOnline,
            'last_heartbeat' => $lastHeartbeat,
            'commands' => [
                '!ping' => 'Check bot responsiveness',
                '!help' => 'Show available commands',
                '!announce' => 'Create an announcement (Admin/Mod only)',
                '!chucknorris' => 'Get a random Chuck Norris joke',
                '!roll' => 'Roll dice (e.g., !roll 2d6)',
                '!flip' => 'Flip a coin',
                '!8ball' => 'Ask the magic 8-ball a question',
                '!trivia' => 'Get a random gaming trivia question',
                '!servers' => 'Show game server status',
            ],
        ]);
    }

    /**
     * Get Discord bot commands list.
     */
    public function commands(): JsonResponse
    {
        return response()->json([
            'commands' => [
                [
                    'name' => '!ping',
                    'description' => 'Check if the bot is responsive',
                    'usage' => '!ping',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!help',
                    'description' => 'Display available commands',
                    'usage' => '!help',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!announce',
                    'description' => 'Create an announcement',
                    'usage' => '!announce Your Title\nYour message',
                    'permission' => 'Admin/Moderator',
                ],
                [
                    'name' => '!chucknorris',
                    'description' => 'Get a random Chuck Norris joke',
                    'usage' => '!chucknorris',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!roll',
                    'description' => 'Roll dice',
                    'usage' => '!roll 2d6 or !roll 1d20',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!flip',
                    'description' => 'Flip a coin',
                    'usage' => '!flip',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!8ball',
                    'description' => 'Ask the magic 8-ball a question',
                    'usage' => '!8ball Will I win?',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!trivia',
                    'description' => 'Get a random gaming trivia question',
                    'usage' => '!trivia',
                    'permission' => 'Everyone',
                ],
                [
                    'name' => '!servers',
                    'description' => 'Show game server status from the website',
                    'usage' => '!servers',
                    'permission' => 'Everyone',
                ],
            ],
        ]);
    }
}
