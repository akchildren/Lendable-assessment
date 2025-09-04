<?php

namespace Lendable\Interview\Service\Calculator;

use Lendable\Interview\DataTransferObject\Loan\LoanFeeData;
use Lendable\Interview\DataTransferObject\Loan\LoanRequestData;

interface LoanFeeCalculator
{
    public function execute(LoanRequestData $loanData): LoanFeeData;
}
