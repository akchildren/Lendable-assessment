<?php
declare(strict_types=1);

namespace Lendable\Interview\Service\Loan\Fee;

use Lendable\Interview\Domain\Loan\LoanApplication;
use Money\Money;

interface LoanFeeCalculatorInterface
{
    /**
     * Calculate the loan fee based on the provided loan data.
     * It will interpolate the fee based on breakpoints bounds and round up to the nearest interval.
     * @param LoanApplication $loanApplication The loan application domain containing amount and term.
     * @return Money The calculated loan fee as a Money object.
     */
    public function calculate(LoanApplication $loanApplication): Money;
}
