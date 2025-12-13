<?php

namespace App\Enums;

enum ReportStatus: string
{
    case PENDING = 'pending';
    case RESOLVED = 'resolved';
    case DISMISSED = 'dismissed';

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
            self::PENDING => 'Pending',
            self::RESOLVED => 'Resolved',
            self::DISMISSED => 'Dismissed',
        };
    }
}
