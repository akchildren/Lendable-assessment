<?php

namespace Lendable\Interview\Service\Loan\Fee;

interface LoanFeeInterpolatorInterface
{
    public function interpolate(
        float $loanAmount,
        array $breakpoints,
    ): float;
}
