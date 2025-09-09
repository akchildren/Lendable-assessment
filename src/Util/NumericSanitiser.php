<?php

declare(strict_types=1);

namespace Lendable\Interview\Util;

final readonly class NumericSanitiser
{
    /**
     * Sanitise formatted float string into strict float type
     * @note Returns string to avoid float precision loss
     */
    public static function sanitizeFloatString(
        string $formatted,
        string $thousandSep = ',',
        string $decimalSep = '.'
    ): string {
        $cleaned = str_replace($thousandSep, '', $formatted);
        if ($decimalSep !== '.') {
            $cleaned = str_replace($decimalSep, '.', $cleaned);
        }

        return preg_replace('/[^\d.-]/', '', $cleaned); // strip stray chars
    }
}
