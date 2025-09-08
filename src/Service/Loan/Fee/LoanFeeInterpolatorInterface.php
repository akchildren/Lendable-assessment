<?php
declare(strict_types=1);

namespace Lendable\Interview\Service\Loan\Fee;

interface LoanFeeInterpolatorInterface
{
    /**
     * Interpolates the fee for a given loan amount based on provided breakpoints.
     * Breakpoints should be an associative array where keys are loan amounts and values are fees.
     * The function assumes that the breakpoints are sorted by loan amount.
     * If the loan amount is outside the range of breakpoints, an exception should be thrown.
     * @param float $loanAmount The loan amount for which the fee needs to be interpolated.
     * @param array<int, int> $breakpoints An associative array of breakpoints [amount => fee].
     */
    public function interpolate(
        float $loanAmount,
        array $breakpoints,
    ): float;
}
