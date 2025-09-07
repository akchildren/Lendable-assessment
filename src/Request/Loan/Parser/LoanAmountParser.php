<?php

namespace Lendable\Interview\Request\Loan\Parser;

use Lendable\Interview\Util\MoneyConverter;
use Lendable\Interview\Util\NumericSanitizer;
use Lendable\Interview\Request\ParserInterface;
use Money\Money;

final readonly class LoanAmountParser implements ParserInterface
{
    public function __construct(
        private string $rawAmount,
        private string $currencyCode = 'GBP'
    ) {
    }

    public function parse(): Money
    {
        $floatAmount = NumericSanitizer::sanitizeFloatString($this->rawAmount);
        return MoneyConverter::parseFloat($floatAmount, $this->currencyCode);
    }
}
