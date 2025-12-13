<?php

namespace App\DiscordBot;

class DiscordPermissions
{
    /**
     * Permission to view a channel.
     */
    public const VIEW_CHANNEL = 1024;

    /**
     * Permission to send messages in a channel.
     */
    public const SEND_MESSAGES = 2048;

    /**
     * Permission to read message history in a channel.
     */
    public const READ_MESSAGE_HISTORY = 65536;

    /**
     * Permission to manage channels.
     */
    public const MANAGE_CHANNELS = 16;

    /**
     * Permission to embed links.
     */
    public const EMBED_LINKS = 16384;

    /**
     * Permission to manage messages.
     */
    public const MANAGE_MESSAGES = 8192;
}
