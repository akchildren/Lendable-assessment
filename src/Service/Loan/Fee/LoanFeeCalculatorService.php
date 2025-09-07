<?php

namespace Lendable\Interview\Service\Loan\Fee;

use Lendable\Interview\DataTransferObject\Loan\LoanApplicationRequestDto;
use Lendable\Interview\Util\MoneyConverter;
use Lendable\Interview\Repository\Loan\Term\LoanTermRepositoryInterface;
use Money\Money;

final readonly class LoanFeeCalculatorService implements LoanFeeCalculatorInterface
{
    public function __construct(
        private LoanTermRepositoryInterface  $loanTermRepository,
        private LoanFeeInterpolatorInterface $interpolator,
        private int $roundingInterval = 5
    ) {
    }

    public function calculate(LoanApplicationRequestDto $loanData): Money
    {
        $loanAmount = $loanData->amount;
        $term = $loanData->term;

        $breakpoints = $this->loanTermRepository->getBreakpointsForTerm($term);

        $interpolatedFee = $this->calculateInterpolatedFee($loanData, $breakpoints);
        return $this->roundFeeUpToNearestInterval($loanAmount, $interpolatedFee);
    }

    /**
     * Calculate the interpolated fee based on the loan amount and breakpoints.
     * @param LoanApplicationRequestDto $loanData The loan application data containing amount and term.
     * @param array<int, int> $breakpoints The breakpoints for interpolation.
     * @return Money The interpolated fee as a Money object.
     */
    private function calculateInterpolatedFee(
        LoanApplicationRequestDto $loanData,
        array                     $breakpoints
    ): Money {
        $loanAmount = MoneyConverter::toFloat($loanData->amount);
        $interpolated = $this->interpolator->interpolate($loanAmount, $breakpoints);

        return MoneyConverter::parseFloat($interpolated);
    }

    /**
     * Rounds the fee up to the nearest specified interval.
     * E.g., if the interval is £5, a fee of £12.34 would be rounded up to £15.00.
     * @param Money $loanAmount The original loan amount.
     * @param Money $interpolatedFee The interpolated fee before rounding.
     * @return Money The rounded fee as a Money object.
     */
    private function roundFeeUpToNearestInterval(
        Money $loanAmount,
        Money $interpolatedFee
    ): Money {
        $intervalPence = (int)($this->roundingInterval * 100); // £5 = 500p

        $loanPence = (int)$loanAmount->getAmount();
        $feePence = (int)$interpolatedFee->getAmount();

        $totalPence = $loanPence + $feePence;
        $remainder = $totalPence % $intervalPence;

        if ($remainder !== 0) {
            $feePence += ($intervalPence - $remainder);
        }

        return MoneyConverter::parseFloat($feePence / 100);
    }
}
