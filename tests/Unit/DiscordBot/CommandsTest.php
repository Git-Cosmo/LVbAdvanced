<?php

namespace Tests\Unit\DiscordBot;

use App\DiscordBot\Commands\AnnounceCommand;
use App\DiscordBot\Commands\HelpCommand;
use App\DiscordBot\Commands\PingCommand;
use Tests\TestCase;

class CommandsTest extends TestCase
{
    public function test_ping_command_has_correct_name(): void
    {
        $command = new PingCommand();
        
        $this->assertEquals('ping', $command->getName());
        $this->assertNotEmpty($command->getDescription());
    }

    public function test_help_command_has_correct_name(): void
    {
        $discord = $this->createMock(\Discord\Discord::class);
        $command = new HelpCommand($discord);
        
        $this->assertEquals('help', $command->getName());
        $this->assertNotEmpty($command->getDescription());
    }

    public function test_announce_command_has_correct_name(): void
    {
        $discord = $this->createMock(\Discord\Discord::class);
        $channelManager = $this->createMock(\App\DiscordBot\Services\ChannelManager::class);
        
        $command = new AnnounceCommand($discord, $channelManager);
        
        $this->assertEquals('announce', $command->getName());
        $this->assertNotEmpty($command->getDescription());
    }

    public function test_ping_command_allows_everyone(): void
    {
        $command = new PingCommand();
        
        // Create a mock message
        $message = $this->createMock(\Discord\Parts\Channel\Message::class);
        
        // Ping command should allow everyone (no roles required)
        $this->assertTrue($command->hasPermission($message));
    }
}
