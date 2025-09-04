<?php

namespace Lendable\Interview\Helper;

final readonly class StringHelper
{
    public static function sanitiseFloatString(
        string $formatted,
        string $thousand_sep = ',',
        string $decimal_sep = '.'
    ): float {
        // Remove thousand separator
        $cleaned = str_replace($thousand_sep, '', $formatted);
        // Replace decimal separator with dot
        if ($decimal_sep !== '.') {
            $cleaned = str_replace($decimal_sep, '.', $cleaned);
        }
        return floatval($cleaned);
    }
}
