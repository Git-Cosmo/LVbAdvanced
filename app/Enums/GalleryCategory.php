<?php

namespace App\Enums;

enum GalleryCategory: string
{
    case MAP = 'map';
    case SKIN = 'skin';
    case MOD = 'mod';
    case TEXTURE = 'texture';
    case SOUND = 'sound';
    case OTHER = 'other';

    /**
     * Get all category values as an array.
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
            self::MAP => 'Map',
            self::SKIN => 'Skin',
            self::MOD => 'Mod',
            self::TEXTURE => 'Texture',
            self::SOUND => 'Sound',
            self::OTHER => 'Other',
        };
    }
}
