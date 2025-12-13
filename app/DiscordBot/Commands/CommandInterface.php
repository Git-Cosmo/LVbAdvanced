<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;

interface CommandInterface
{
    /**
     * Get the command name (without the ! prefix).
     */
    public function getName(): string;

    /**
     * Get the command description.
     */
    public function getDescription(): string;

    /**
     * Execute the command.
     *
     * @param Message $message The Discord message that triggered the command
     * @param string $args The arguments passed to the command
     */
    public function execute(Message $message, string $args): void;

    /**
     * Check if the user has permission to use this command.
     */
    public function hasPermission(Message $message): bool;
}
