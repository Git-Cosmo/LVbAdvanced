<?php

namespace App\DiscordBot\Services;

use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Guild\Guild;
use Illuminate\Support\Facades\Log;
use React\Promise\PromiseInterface;

class ChannelManager
{
    protected Discord $discord;

    protected array $channelCache = [];

    protected array $categoryCache = [];

    public function __construct(Discord $discord)
    {
        $this->discord = $discord;
    }

    /**
     * Provision all required channels from config.
     */
    public function provisionChannels(): void
    {
        $guildId = config('discord_channels.guild_id');

        if (! $guildId) {
            Log::warning('Discord guild ID not configured');

            return;
        }

        $this->discord->guilds->fetch($guildId)->done(function (Guild $guild) {
            Log::info('Provisioning channels for guild', ['guild' => $guild->name]);

            // First, create/fetch categories
            $this->provisionCategories($guild)->done(function () use ($guild) {
                // Then create/fetch channels
                $this->provisionChannelsInGuild($guild);
            });
        }, function ($error) {
            Log::error('Failed to fetch guild', ['error' => $error]);
        });
    }

    /**
     * Provision channel categories.
     */
    protected function provisionCategories(Guild $guild): PromiseInterface
    {
        $categories = config('discord_channels.categories', []);
        $promises = [];

        foreach ($categories as $categoryName => $settings) {
            $promises[] = $this->ensureCategory($guild, $categoryName, $settings);
        }

        return \React\Promise\all($promises);
    }

    /**
     * Ensure a category exists.
     */
    protected function ensureCategory(Guild $guild, string $name, array $settings): PromiseInterface
    {
        // Check if category already exists
        $existingCategory = $guild->channels->find(function (Channel $channel) use ($name) {
            return $channel->type === Channel::TYPE_CATEGORY && strtolower($channel->name) === strtolower($name);
        });

        if ($existingCategory) {
            $this->categoryCache[$name] = $existingCategory;
            Log::info('Category already exists', ['category' => $name]);

            return \React\Promise\resolve($existingCategory);
        }

        // Create the category
        return $guild->channels->create([
            'name' => $name,
            'type' => Channel::TYPE_CATEGORY,
            'position' => $settings['position'] ?? 0,
        ])->then(function (Channel $category) use ($name) {
            $this->categoryCache[$name] = $category;
            Log::info('Created category', ['category' => $name]);

            return $category;
        });
    }

    /**
     * Provision channels in the guild.
     */
    protected function provisionChannelsInGuild(Guild $guild): void
    {
        $channels = config('discord_channels.channels', []);

        foreach ($channels as $key => $channelConfig) {
            $this->ensureChannel($guild, $channelConfig);
        }
    }

    /**
     * Ensure a channel exists.
     */
    protected function ensureChannel(Guild $guild, array $config): void
    {
        $channelName = $config['name'];

        // Check if channel already exists
        $existingChannel = $guild->channels->find(function (Channel $channel) use ($channelName) {
            return $channel->type !== Channel::TYPE_CATEGORY && strtolower($channel->name) === strtolower($channelName);
        });

        if ($existingChannel) {
            $this->channelCache[$channelName] = $existingChannel;
            Log::info('Channel already exists', ['channel' => $channelName]);

            return;
        }

        // Create the channel
        $createParams = [
            'name' => $channelName,
            'type' => $config['type'] ?? Channel::TYPE_TEXT,
            'topic' => $config['topic'] ?? null,
        ];

        // Add category if specified
        if (isset($config['category']) && isset($this->categoryCache[$config['category']])) {
            $createParams['parent_id'] = $this->categoryCache[$config['category']]->id;
        }

        $guild->channels->create($createParams)->done(function (Channel $channel) use ($channelName, $config) {
            $this->channelCache[$channelName] = $channel;
            Log::info('Created channel', ['channel' => $channelName]);

            // Apply permissions if configured
            if (isset($config['permissions'])) {
                $this->applyChannelPermissions($channel, $config['permissions']);
            }
        }, function ($error) use ($channelName) {
            Log::error('Failed to create channel', [
                'channel' => $channelName,
                'error' => $error,
            ]);
        });
    }

    /**
     * Apply permissions to a channel.
     */
    protected function applyChannelPermissions(Channel $channel, array $permissions): void
    {
        // Permission application will be implemented based on specific needs
        // This is a placeholder for permission logic
        Log::info('Permissions configured for channel', [
            'channel' => $channel->name,
            'permissions' => array_keys($permissions),
        ]);
    }

    /**
     * Get a channel by name.
     */
    public function getChannelByName(string $name): ?Channel
    {
        return $this->channelCache[$name] ?? null;
    }

    /**
     * Get the announcements channel.
     */
    public function getAnnouncementsChannel(): ?Channel
    {
        return $this->getChannelByName('announcements');
    }

    /**
     * Refresh channel cache from guild.
     */
    public function refreshChannelCache(Guild $guild): void
    {
        $this->channelCache = [];

        foreach ($guild->channels as $channel) {
            if ($channel->type !== Channel::TYPE_CATEGORY) {
                $this->channelCache[$channel->name] = $channel;
            }
        }
    }
}
