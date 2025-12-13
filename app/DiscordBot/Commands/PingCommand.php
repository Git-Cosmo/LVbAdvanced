<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;

class PingCommand extends BaseCommand
{
    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'ping';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Check if the bot is responsive';
    }

    /**
     * Execute the ping command.
     */
    public function execute(Message $message, string $args): void
    {
        $message->reply('🏓 Pong!');
    }
}
