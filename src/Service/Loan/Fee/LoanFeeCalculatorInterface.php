<?php

namespace Lendable\Interview\Service\Loan\Fee;

use Lendable\Interview\DataTransferObject\Loan\LoanApplicationRequestDto;
use Money\Money;

interface LoanFeeCalculatorInterface
{
    public function execute(LoanApplicationRequestDto $loanData): Money;
}
