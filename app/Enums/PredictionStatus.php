<?php

namespace App\Enums;

enum PredictionStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case RESOLVED = 'resolved';
    case CANCELLED = 'cancelled';

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
            self::OPEN => 'Open',
            self::CLOSED => 'Closed',
            self::RESOLVED => 'Resolved',
            self::CANCELLED => 'Cancelled',
        };
    }
}
