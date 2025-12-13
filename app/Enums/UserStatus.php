<?php

namespace App\Enums;

enum UserStatus: string
{
    case ONLINE = 'online';
    case AWAY = 'away';
    case BUSY = 'busy';
    case OFFLINE = 'offline';

    /**
     * Get all status values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get validation rule string.
     *
     * @return string
     */
    public static function validationRule(): string
    {
        return 'in:'.implode(',', self::values());
    }

    /**
     * Get human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::ONLINE => 'Online',
            self::AWAY => 'Away',
            self::BUSY => 'Busy',
            self::OFFLINE => 'Offline',
        };
    }
}
