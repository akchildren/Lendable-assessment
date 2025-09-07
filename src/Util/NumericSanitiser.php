<?php

namespace Lendable\Interview\Util;

final readonly class NumericSanitiser
{
    /**
     * Sanitise formatted float string into strict float type
     */
    public static function sanitizeFloatString(
        string $formatted,
        string $thousandSep = ',',
        string $decimalSep = '.'
    ): float {
        $cleaned = str_replace($thousandSep, '', $formatted);
        if ($decimalSep !== '.') {
            $cleaned = str_replace($decimalSep, '.', $cleaned);
        }
        $cleaned = preg_replace('/[^\d.-]/', '', $cleaned); // strip stray chars

        return (float) $cleaned;
    }
}
