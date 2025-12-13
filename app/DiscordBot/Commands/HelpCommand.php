<?php

namespace App\DiscordBot\Commands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class HelpCommand extends BaseCommand
{
    /**
     * @var CommandInterface[]
     */
    protected array $commands = [];

    public function __construct(protected Discord $discord)
    {
    }

    /**
     * Get the command name.
     */
    public function getName(): string
    {
        return 'help';
    }

    /**
     * Get the command description.
     */
    public function getDescription(): string
    {
        return 'Show this help message';
    }

    /**
     * Set the available commands for the help message.
     *
     * @param CommandInterface[] $commands
     */
    public function setCommands(array $commands): void
    {
        $this->commands = $commands;
    }

    /**
     * Execute the help command.
     */
    public function execute(Message $message, string $args): void
    {
        $embed = new Embed($this->discord);
        $embed
            ->setTitle('🤖 Bot Commands')
            ->setDescription('Here are the available commands:')
            ->setColor('#5865F2')
            ->setTimestamp();

        // Add each command to the embed
        foreach ($this->commands as $command) {
            $commandName = '!' . $command->getName();
            if ($command->getName() === 'announce') {
                $commandName .= ' <title>\\n<message>';
            }
            $embed->addFieldValues($commandName, $command->getDescription());
        }

        $message->channel->sendEmbed($embed);
    }
}
