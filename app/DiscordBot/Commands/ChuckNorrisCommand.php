<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChuckNorrisCommand extends BaseCommand
{
    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'chucknorris';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Get a random Chuck Norris joke';
    }

    /**
     * Execute the Chuck Norris command.
     */
    public function execute(Message $message, string $args): void
    {
        try {
            // Fetch a random Chuck Norris joke from the API
            $response = Http::timeout(5)->get('https://api.chucknorris.io/jokes/random');

            if ($response->successful()) {
                $data = $response->json();
                $joke = $data['value'] ?? 'Could not fetch a Chuck Norris joke.';
                
                $message->reply("💪 **Chuck Norris Fact:**\n{$joke}");
                
                Log::info('Chuck Norris command executed', [
                    'user' => $message->author->username,
                    'channel' => $message->channel_id,
                ]);
            } else {
                $message->reply('❌ Failed to fetch a Chuck Norris joke. Please try again later.');
                Log::warning('Chuck Norris API returned non-successful response', [
                    'status' => $response->status(),
                ]);
            }
        } catch (\Exception $e) {
            $message->reply('❌ An error occurred while fetching a Chuck Norris joke.');
            Log::error('Chuck Norris command failed', [
                'error' => $e->getMessage(),
                'user' => $message->author->username,
            ]);
        }
    }
}
