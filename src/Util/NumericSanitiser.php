<?php

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
        // Remove thousands separator
        if ($thousandSep !== '') {
            $formatted = str_replace($thousandSep, '', $formatted);
        }

        // Normalize decimal separator
        if ($decimalSep !== '.' && $decimalSep !== '') {
            $formatted = str_replace($decimalSep, '.', $formatted);
        }

        // Keep digits, one dot, and an optional leading minus
        $formatted = preg_replace('/[^0-9.\-]/', '', $formatted);

        // Normalize multiple dots or misplaced minus signs
        $formatted = preg_replace('/(?!^)-/', '', $formatted); // Remove all but leading minus
        $formatted = preg_replace('/(?<=\..*)\./', '', $formatted); // Remove extra dots after first

        return (string) $formatted;
    }
}
