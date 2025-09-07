<?php

namespace Lendable\Interview\Service\Loan\Fee;

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

        [$lowerAmount, $upperAmount] = $this->findSurroundingBreakpoints($loanAmount, $breakpoints);

        return $this->linearInterpolation(
            loanAmount: $loanAmount,
            lowerBreakpointAmount: $lowerAmount,
            upperBreakpointAmount: $upperAmount,
            lowerBreakpointFee: $breakpoints[$lowerAmount],
            upperBreakpointFee: $breakpoints[$upperAmount]
        );
    }

    private function findSurroundingBreakpoints(float $loanAmount, array $breakpoints): array
    {
        $keys = array_keys($breakpoints);

        $lower = null;
        $upper = null;

        foreach ($keys as $key) {
            if ($key < $loanAmount) {
                $lower = $key;
            }

            if ($key > $loanAmount && $lower !== null) {
                $upper = $key;
                break;
            }
        }

        if ($lower === null || $upper === null) {
            throw new \InvalidArgumentException("Loan amount is out of interpolation bounds.");
        }

        return [$lower, $upper];
    }

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
