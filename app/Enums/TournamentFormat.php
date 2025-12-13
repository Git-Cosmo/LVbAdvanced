<?php

namespace App\Enums;

enum TournamentFormat: string
{
    case SINGLE_ELIMINATION = 'single_elimination';
    case DOUBLE_ELIMINATION = 'double_elimination';
    case ROUND_ROBIN = 'round_robin';
    case SWISS = 'swiss';

    /**
     * Get all format values as an array.
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
            self::SINGLE_ELIMINATION => 'Single Elimination',
            self::DOUBLE_ELIMINATION => 'Double Elimination',
            self::ROUND_ROBIN => 'Round Robin',
            self::SWISS => 'Swiss',
        };
    }
}
