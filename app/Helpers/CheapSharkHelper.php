<?php

namespace App\Helpers;

class CheapSharkHelper
{
    /**
     * Get the base URL for CheapShark (website, not API).
     */
    public static function baseUrl(): string
    {
        // Use the website base URL for images and redirects, not the API URL
        $apiUrl = config('services.cheapshark.base_url', 'https://www.cheapshark.com/api/1.0');
        // Extract the base domain from the API URL
        return rtrim(preg_replace('#/api/.*$#', '', $apiUrl), '/');
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
