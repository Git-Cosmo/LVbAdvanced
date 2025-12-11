<?php

namespace App\Helpers;

class CheapSharkHelper
{
    /**
     * Get the base URL for CheapShark.
     */
    public static function baseUrl(): string
    {
        return rtrim(config('services.cheapshark.base_url', 'https://www.cheapshark.com'), '/');
    }

    /**
     * Get the full URL for a CheapShark logo image.
     */
    public static function logoUrl(?string $logoPath): ?string
    {
        if (empty($logoPath)) {
            return null;
        }

        return self::baseUrl() . '/' . ltrim($logoPath, '/');
    }

    /**
     * Get the redirect URL for a deal.
     */
    public static function dealRedirectUrl(string $dealId): string
    {
        return self::baseUrl() . '/redirect?dealID=' . $dealId;
    }
}
