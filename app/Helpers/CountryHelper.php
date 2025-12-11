<?php

namespace App\Helpers;

class CountryHelper
{
    /**
     * Derive country flag emoji and label from request headers or profile location.
     *
     * @return array{0:string,1:string}
     */
    public static function getUserCountryInfo(): array
    {
        $countryCode = request()->header('CF-IPCountry')
            ?? request()->server('HTTP_CF_IPCOUNTRY')
            ?? optional(optional(auth()->user())->profile)->location;

        if ($countryCode) {
            $code = mb_strtoupper(mb_substr($countryCode, 0, 2, 'UTF-8'), 'UTF-8');
            $countryCode = preg_match('/^[A-Z]{2}$/', $code) ? $code : null;
        } else {
            $countryCode = null;
        }

        $flagEmoji = $countryCode
            ? mb_chr(ord($countryCode[0]) + 127397) . mb_chr(ord($countryCode[1]) + 127397)
            : '🌐';

        $countryLabel = $countryCode ?? 'Worldwide';

        return [$flagEmoji, $countryLabel];
    }
}
