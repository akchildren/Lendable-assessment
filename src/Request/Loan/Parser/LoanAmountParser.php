<?php

namespace Lendable\Interview\Request\Loan\Parser;

use Lendable\Interview\Util\MoneyConverter;
use Lendable\Interview\Util\NumericSanitiser;
use Lendable\Interview\Request\ParserInterface;
use Money\Money;

/**
 * Parses raw loan amount input into a Money object.
 */
final readonly class LoanAmountParser implements ParserInterface
{
    /**
     * @param non-empty-string $rawAmount
     * @param non-empty-string $currencyCode
     */
    public function __construct(
        private string $rawAmount,
        private string $currencyCode = 'GBP'
    ) {
    }

    public function parse(): Money
    {
        $floatAmount = NumericSanitiser::sanitizeFloatString($this->rawAmount);
        return MoneyConverter::parseFloat($floatAmount, $this->currencyCode);
    }
}
