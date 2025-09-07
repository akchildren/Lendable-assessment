<?php

namespace Lendable\Interview\Util;

final readonly class NumericSanitizer
{
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
