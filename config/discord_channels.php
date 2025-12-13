<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Discord Bot Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Discord bot, including
    | the bot token, guild (server) ID, and required channels.
    |
    */

    'token' => env('DISCORD_BOT_TOKEN'),
    'guild_id' => env('DISCORD_GUILD_ID'),

    /*
    |--------------------------------------------------------------------------
    | Required Channels
    |--------------------------------------------------------------------------
    |
    | These channels will be automatically created if they don't exist when
    | the bot starts. Each channel can have permissions and a category.
    |
    */

    'channels' => [
        // Community Channels
        'announcements' => [
            'name' => 'announcements',
            'type' => 0, // 0 = GUILD_TEXT
            'category' => 'Community',
            'topic' => 'Official announcements and updates',
            'permissions' => [
                'everyone' => [
                    'view_channel' => true,
                    'send_messages' => false,
                    'read_message_history' => true,
                ],
            ],
        ],
        'live-streams' => [
            'name' => 'live-streams',
            'type' => 0,
            'category' => 'Community',
            'topic' => 'Live stream announcements and notifications',
            'permissions' => [
                'everyone' => [
                    'view_channel' => true,
                    'send_messages' => true,
                    'read_message_history' => true,
                ],
            ],
        ],

        // Systems Channels
        'game-status' => [
            'name' => 'game-status',
            'type' => 0,
            'category' => 'Systems',
            'topic' => 'Real-time game server status updates',
            'permissions' => [
                'everyone' => [
                    'view_channel' => true,
                    'send_messages' => false,
                    'read_message_history' => true,
                ],
            ],
        ],
        'leaderboards' => [
            'name' => 'leaderboards',
            'type' => 0,
            'category' => 'Systems',
            'topic' => 'Player rankings and leaderboard updates',
            'permissions' => [
                'everyone' => [
                    'view_channel' => true,
                    'send_messages' => false,
                    'read_message_history' => true,
                ],
            ],
        ],

        // Moderation Channels
        'moderation-logs' => [
            'name' => 'moderation-logs',
            'type' => 0,
            'category' => 'Moderation',
            'topic' => 'Moderation action logs',
            'permissions' => [
                'everyone' => [
                    'view_channel' => false,
                ],
                'moderator' => [
                    'view_channel' => true,
                    'send_messages' => false,
                    'read_message_history' => true,
                ],
            ],
        ],

        // Bot Channels
        'bot-commands' => [
            'name' => 'bot-commands',
            'type' => 0,
            'category' => 'Community',
            'topic' => 'Bot commands and interactions',
            'permissions' => [
                'everyone' => [
                    'view_channel' => true,
                    'send_messages' => true,
                    'read_message_history' => true,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Channel Categories
    |--------------------------------------------------------------------------
    |
    | Define the order and settings for channel categories.
    |
    */

    'categories' => [
        'Community' => [
            'position' => 1,
        ],
        'Systems' => [
            'position' => 2,
        ],
        'Moderation' => [
            'position' => 3,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bot Permissions
    |--------------------------------------------------------------------------
    |
    | Define role-based permissions for bot commands.
    |
    */

    'permissions' => [
        'announce' => ['admin', 'moderator'],
        'manage_channels' => ['admin'],
    ],
];
