<?php

namespace Lendable\Interview\Service\Calculator;

use Lendable\Interview\DataTransferObject\Loan\LoanRequestData;
use Lendable\Interview\DataTransferObject\Loan\LoanTotalResponseData;
use Lendable\Interview\Helper\MoneyHelper;
use Lendable\Interview\Service\Breakpoint\LoanTermBreakpointService;
use Money\Money;

final readonly class LoanFeeCalculatorService
{
    public function __construct(
        private LoanTermBreakpointService $termBreakpointService,
        private int $roundingFeeInterval = 5
    ) {
    }

    public function execute(LoanRequestData $loanData): LoanTotalResponseData
    {
        $breakpoints = $this->termBreakpointService->getSortedBreakdownForTerm($loanData->getTerm());
        $fee = $this->findBreakpointFee($loanData, $breakpoints);

        return new LoanTotalResponseData(
            amount: $loanData->getAmount(),
            fee: $this->roundFeeUpToNearestInterval($loanData->getAmountInPounds(), $fee),
        );
    }

    private function findBreakpointFee(
        LoanRequestData $loanData,
        array $breakpoints
    ): int {
        $keys = array_keys($breakpoints);
        $lowerBoundAmount = null;
        $upperBoundAmount = null;

        $loanAmount = $loanData->getAmountInPounds();

        foreach ($keys as $key) {
            if ($key < $loanAmount) {
                $lowerBoundAmount = $key;
            }
            if ($key > $loanAmount && $lowerBoundAmount !== null) {
                $upperBoundAmount = $key;
                break;
            }
        }

        return self::calculateFeeByLinearInterpolation(
            loanAmount: $loanAmount,
            lowerAmount: $lowerBoundAmount,
            upperAmount: $upperBoundAmount,
            feeLower: $breakpoints[$lowerBoundAmount],
            feeUpper: $breakpoints[$upperBoundAmount]
        );
    }

    private static function calculateFeeByLinearInterpolation(
        float $loanAmount,
        float $lowerAmount,
        float $upperAmount,
        float $feeLower,
        float $feeUpper
    ): float {
        // Linear interpolation formula:
        return round($feeLower +
            (($loanAmount - $lowerAmount) /
                ($upperAmount - $lowerAmount)) *
            ($feeUpper - $feeLower), 2, mode: PHP_ROUND_HALF_UP);
    }

    private function roundFeeUpToNearestInterval(
        float $loanAmountInPounds,
        float $interpolatedFeeInPounds
    ): Money {
        $roundedTotal = round($loanAmountInPounds + $interpolatedFeeInPounds, 0, PHP_ROUND_HALF_UP);
        $remainder = $roundedTotal % $this->roundingFeeInterval;
        if ($remainder !== 0) {
            $interpolatedFeeInPounds += $this->roundingFeeInterval - $remainder;
        }
        return MoneyHelper::parseFloat($interpolatedFeeInPounds);
    }
}
