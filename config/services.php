<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'steam' => [
        'client_id' => null,
        'client_secret' => env('STEAM_API_KEY'),
        'redirect' => env('APP_URL').'/auth/steam/callback',
    ],

    'cheapshark' => [
        'base_url' => env('CHEAPSHARK_BASE_URL', 'https://www.cheapshark.com/api/1.0'),
    ],

    'discord' => [
        'client_id' => env('DISCORD_CLIENT_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/auth/discord/callback',
    ],

    'battlenet' => [
        'client_id' => env('BATTLENET_CLIENT_ID'),
        'client_secret' => env('BATTLENET_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/auth/battlenet/callback',
        'region' => env('BATTLENET_REGION', 'us'),
    ],

    'azuracast' => [
        'base_url' => env('AZURACAST_BASE_URL'),
        'api_key' => env('AZURACAST_API_KEY'),
        'station_id' => env('AZURACAST_STATION_ID'),
    ],

    'openwebninja' => [
        'api_key' => env('OPEN_WEB_NINJA_API_KEY'),
    ],

    'reddit' => [
        'client_id' => env('REDDIT_CLIENT_ID'),
        'client_secret' => env('REDDIT_CLIENT_SECRET'),
        'username' => env('REDDIT_USERNAME'),
        'password' => env('REDDIT_PASSWORD'),
    ],

    'icecast' => [
        'stream_url' => env('ICECAST_STREAM_URL'),
    ],

];
