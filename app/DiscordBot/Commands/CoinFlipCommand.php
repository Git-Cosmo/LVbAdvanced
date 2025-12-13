<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Log;

class CoinFlipCommand extends BaseCommand
{
    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'flip';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Flip a coin (heads or tails)';
    }

    /**
     * Execute the coin flip command.
     */
    public function execute(Message $message, string $args): void
    {
        $result = random_int(0, 1) === 0 ? 'Heads' : 'Tails';
        $emoji = $result === 'Heads' ? '👑' : '⚡';
        
        $response = "{$emoji} **{$message->author->username}** flipped a coin: **{$result}**!";
        
        $message->channel->sendMessage($response);
        
        Log::info('Coin flip command executed', [
            'user' => $message->author->username,
            'result' => $result,
        ]);
    }
}
