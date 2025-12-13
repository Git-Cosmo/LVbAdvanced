<?php

namespace App\Enums;

enum ModerationAction: string
{
    case DISMISS = 'dismiss';
    case DELETE_CONTENT = 'delete_content';
    case WARN_USER = 'warn_user';
    case BAN_USER = 'ban_user';

    /**
     * Get all action values as an array.
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
            self::DISMISS => 'Dismiss Report',
            self::DELETE_CONTENT => 'Delete Content',
            self::WARN_USER => 'Warn User',
            self::BAN_USER => 'Ban User',
        };
    }
}
