<?php

namespace Lendable\Interview\Helper;

use Money\Currency;
use Money\Money;

final readonly class MoneyHelper
{
    public static function parseFloat(float $amount, string $currencyCode = 'GBP'): Money
    {
        $amountInPence = (int)round($amount * 100);
        return new Money($amountInPence, new Currency($currencyCode));
    }

    public static function toFloat(Money $money): float
    {
        return (float)bcdiv($money->getAmount(), '100', 2);
    }
}
