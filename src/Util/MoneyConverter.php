<?php

namespace Lendable\Interview\Util;

use Money\Currency;
use Money\Money;

final readonly class MoneyConverter
{
    /**
     * Parse a float amount into a Money object.
     */
    public static function parseFloat(float $amount, string $currencyCode = 'GBP'): Money
    {
        $amountInPence = (int)round($amount * 100);
        return new Money($amountInPence, new Currency($currencyCode));
    }

    /**
     * Convert a Money object to a float amount.
     */
    public static function toFloat(Money $money): float
    {
        return (float)bcdiv($money->getAmount(), '100', 2);
    }
}
