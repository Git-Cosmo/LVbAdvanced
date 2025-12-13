<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Log;

class DiceRollCommand extends BaseCommand
{
    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'roll';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Roll dice (e.g., !roll 2d6 or !roll 1d20)';
    }

    /**
     * Execute the dice roll command.
     */
    public function execute(Message $message, string $args): void
    {
        // Default to 1d6 if no args provided
        $diceNotation = trim($args) ?: '1d6';
        
        // Parse dice notation (e.g., "2d6", "1d20")
        if (!preg_match('/^(\d+)d(\d+)$/i', $diceNotation, $matches)) {
            $message->reply('❌ Invalid dice notation. Use format: `!roll 2d6` or `!roll 1d20`');
            return;
        }
        
        $numDice = (int) $matches[1];
        $numSides = (int) $matches[2];
        
        // Validate limits
        if ($numDice < 1 || $numDice > 100) {
            $message->reply('❌ Number of dice must be between 1 and 100.');
            return;
        }
        
        if ($numSides < 2 || $numSides > 1000) {
            $message->reply('❌ Number of sides must be between 2 and 1000.');
            return;
        }
        
        // Roll the dice
        $rolls = [];
        $total = 0;
        
        for ($i = 0; $i < $numDice; $i++) {
            $roll = random_int(1, $numSides);
            $rolls[] = $roll;
            $total += $roll;
        }
        
        // Format the response
        $rollsDisplay = $numDice <= 10 ? ' (' . implode(', ', $rolls) . ')' : '';
        $response = "🎲 **{$message->author->username}** rolled **{$diceNotation}**: **{$total}**{$rollsDisplay}";
        
        $message->channel->sendMessage($response);
        
        Log::info('Dice roll command executed', [
            'user' => $message->author->username,
            'dice' => $diceNotation,
            'result' => $total,
        ]);
    }
}
