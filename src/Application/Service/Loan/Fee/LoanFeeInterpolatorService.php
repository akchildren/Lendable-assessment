<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Service\Loan\Fee;

use InvalidArgumentException;

final readonly class LoanFeeInterpolatorService implements LoanFeeInterpolatorInterface
{
    public function interpolate(
        float $loanAmount,
        array $breakpoints
    ): float {
        // Check for exact match before interpolating
        if (isset($breakpoints[(int)round($loanAmount)])) {
            return (float)$breakpoints[(int)round($loanAmount)];
        }

        [$lowerAmount, $upperAmount] = $this->findSurroundingBreakpoints(
            loanAmount: $loanAmount,
            breakpoints: $breakpoints
        );

        return $this->linearInterpolation(
            loanAmount: $loanAmount,
            lowerBreakpointAmount: $lowerAmount,
            upperBreakpointAmount: $upperAmount,
            lowerBreakpointFee: $breakpoints[$lowerAmount],
            upperBreakpointFee: $breakpoints[$upperAmount]
        );
    }

    /**
     * Finds the two breakpoints that surround the given loan amount.
     * Assumes breakpoints are sorted by key (loan amount).
     *
     * @param float $loanAmount
     * @param array<int, int> $breakpoints
     * @return array{int, int} [lowerBreakpoint, upperBreakpoint]
     * @throws InvalidArgumentException if no surrounding breakpoints are found
     */
    private function findSurroundingBreakpoints(
        float $loanAmount,
        array $breakpoints
    ): array {
        $lowerBound = null;
        $upperBound = null;

        foreach ($breakpoints as $amount => $_) {
            if ($amount < $loanAmount) {
                $lowerBound = $amount;
                continue;
            }

            if ($amount > $loanAmount && $lowerBound !== null) {
                $upperBound = $amount;
                break;
            }
        }

        if ($lowerBound === null || $upperBound === null) {
            throw new InvalidArgumentException("Loan amount is out of interpolation bounds.");
        }

        return [$lowerBound, $upperBound];
    }

    /**
     * Performs linear interpolation between two breakpoints.
     *
     * @param float $loanAmount
     * @param int $lowerBreakpointAmount
     * @param int $upperBreakpointAmount
     * @param int $lowerBreakpointFee
     * @param int $upperBreakpointFee
     * @return float The interpolated fee, rounded to 2 decimal places.
     */
    private function linearInterpolation(
        float $loanAmount,
        int $lowerBreakpointAmount,
        int $upperBreakpointAmount,
        int $lowerBreakpointFee,
        int $upperBreakpointFee
    ): float {
        $proportion = ($loanAmount - $lowerBreakpointAmount) / ($upperBreakpointAmount - $lowerBreakpointAmount);
        $result = $lowerBreakpointFee + $proportion * ($upperBreakpointFee - $lowerBreakpointFee);

        return round($result, 2, mode: PHP_ROUND_HALF_UP);
    }
}
