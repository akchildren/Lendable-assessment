<?php

namespace Lendable\Interview\Service\Loan\Fee;

use Lendable\Interview\DataTransferObject\Loan\LoanApplicationRequestDto;
use Money\Money;

interface LoanFeeCalculatorInterface
{
    /**
     * Calculate the loan fee based on the provided loan data.
     * It will interpolate the fee based on breakpoints bounds and round up to the nearest interval.
     * @param LoanApplicationRequestDto $loanData The loan application data containing amount and term.
     * @return Money The calculated loan fee as a Money object.
     */
    public function calculate(LoanApplicationRequestDto $loanData): Money;
}
