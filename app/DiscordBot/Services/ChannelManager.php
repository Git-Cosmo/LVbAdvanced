<?php

namespace App\DiscordBot\Services;

use App\DiscordBot\DiscordPermissions;
use Discord\Builders\ChannelBuilder;
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

        $this->discord->guilds->fetch($guildId)->then(function (Guild $guild) {
            Log::info('Provisioning channels for guild', ['guild' => $guild->name]);

            // First, create/fetch categories
            $this->provisionCategories($guild)->then(function () use ($guild) {
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

        // Create the category using ChannelBuilder
        $builder = ChannelBuilder::new($name)
            ->setType(Channel::TYPE_CATEGORY)
            ->setPosition($settings['position'] ?? 0);

        // Create channel and return promise
        return $guild->createChannel($builder)->then(
            function (Channel $category) use ($name) {
                $this->categoryCache[$name] = $category;
                Log::info('Created category', ['category' => $name]);
                return $category;
            },
            function ($error) use ($name) {
                Log::error('Failed to create category', [
                    'category' => $name,
                    'error' => (string) $error,
                ]);
                throw $error;
            }
        );
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

        // Create the channel using ChannelBuilder
        $builder = ChannelBuilder::new($channelName)
            ->setType($config['type'] ?? Channel::TYPE_TEXT);

        if (isset($config['topic'])) {
            $builder->setTopic($config['topic']);
        }

        // Add category if specified
        if (isset($config['category']) && isset($this->categoryCache[$config['category']])) {
            $builder->setParentId($this->categoryCache[$config['category']]->id);
        }

        // Create channel using promise-based save method
        $guild->createChannel($builder)->then(
            function (Channel $channel) use ($channelName, $config) {
                $this->channelCache[$channelName] = $channel;
                Log::info('Created channel', ['channel' => $channelName]);

                // Apply permissions if configured
                if (isset($config['permissions'])) {
                    $this->applyChannelPermissions($channel, $config['permissions']);
                }
            },
            function ($error) use ($channelName) {
                Log::error('Failed to create channel', [
                    'channel' => $channelName,
                    'error' => (string) $error,
                ]);
            }
        );
    }

    /**
     * Apply permissions to a channel.
     */
    protected function applyChannelPermissions(Channel $channel, array $permissions): void
    {
        $guild = $channel->guild;
        
        foreach ($permissions as $roleName => $perms) {
            try {
                if ($roleName === 'everyone') {
                    // Apply permissions to @everyone role
                    $everyoneRole = $guild->roles->get('id', $guild->id);
                    if ($everyoneRole) {
                        $overwrite = [
                            'id' => $everyoneRole->id,
                            'type' => 'role',
                            'allow' => 0,
                            'deny' => 0,
                        ];

                        // Calculate permission bits
                        if (isset($perms['view_channel'])) {
                            if ($perms['view_channel']) {
                                $overwrite['allow'] |= DiscordPermissions::VIEW_CHANNEL;
                            } else {
                                $overwrite['deny'] |= DiscordPermissions::VIEW_CHANNEL;
                            }
                        }

                        if (isset($perms['send_messages'])) {
                            if ($perms['send_messages']) {
                                $overwrite['allow'] |= DiscordPermissions::SEND_MESSAGES;
                            } else {
                                $overwrite['deny'] |= DiscordPermissions::SEND_MESSAGES;
                            }
                        }

                        if (isset($perms['read_message_history'])) {
                            if ($perms['read_message_history']) {
                                $overwrite['allow'] |= DiscordPermissions::READ_MESSAGE_HISTORY;
                            } else {
                                $overwrite['deny'] |= DiscordPermissions::READ_MESSAGE_HISTORY;
                            }
                        }

                        $channel->setPermissions($everyoneRole, $overwrite['allow'], $overwrite['deny']);
                        
                        Log::info('Applied permissions to channel', [
                            'channel' => $channel->name,
                            'role' => '@everyone',
                            'allow' => $overwrite['allow'],
                            'deny' => $overwrite['deny'],
                        ]);
                    }
                } else {
                    // Find the role by name
                    $role = $guild->roles->find(function ($r) use ($roleName) {
                        return strtolower($r->name) === strtolower($roleName);
                    });

                    if ($role) {
                        $overwrite = [
                            'allow' => 0,
                            'deny' => 0,
                        ];

                        // Calculate permission bits for custom roles
                        if (isset($perms['view_channel'])) {
                            if ($perms['view_channel']) {
                                $overwrite['allow'] |= DiscordPermissions::VIEW_CHANNEL;
                            } else {
                                $overwrite['deny'] |= DiscordPermissions::VIEW_CHANNEL;
                            }
                        }

                        if (isset($perms['send_messages'])) {
                            if ($perms['send_messages']) {
                                $overwrite['allow'] |= DiscordPermissions::SEND_MESSAGES;
                            } else {
                                $overwrite['deny'] |= DiscordPermissions::SEND_MESSAGES;
                            }
                        }

                        if (isset($perms['read_message_history'])) {
                            if ($perms['read_message_history']) {
                                $overwrite['allow'] |= DiscordPermissions::READ_MESSAGE_HISTORY;
                            } else {
                                $overwrite['deny'] |= DiscordPermissions::READ_MESSAGE_HISTORY;
                            }
                        }

                        $channel->setPermissions($role, $overwrite['allow'], $overwrite['deny']);

                        Log::info('Applied permissions to channel', [
                            'channel' => $channel->name,
                            'role' => $roleName,
                            'allow' => $overwrite['allow'],
                            'deny' => $overwrite['deny'],
                        ]);
                    } else {
                        Log::warning('Role not found for permission application', [
                            'channel' => $channel->name,
                            'role' => $roleName,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Failed to apply permissions to channel', [
                    'channel' => $channel->name,
                    'role' => $roleName,
                    'error' => $e->getMessage(),
                ]);
            }
        }
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
