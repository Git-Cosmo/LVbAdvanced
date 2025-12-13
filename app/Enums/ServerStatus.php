<?php

namespace App\Enums;

enum ServerStatus: string
{
    case ONLINE = 'online';
    case OFFLINE = 'offline';
    case MAINTENANCE = 'maintenance';
    case COMING_SOON = 'coming_soon';

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
            self::OFFLINE => 'Offline',
            self::MAINTENANCE => 'Maintenance',
            self::COMING_SOON => 'Coming Soon',
        };
    }
}
