<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Service\Loan\Fee;

use Lendable\Interview\Domain\Loan\LoanApplication;
use Lendable\Interview\Domain\Loan\LoanTermBreakpoints;
use Lendable\Interview\Infrastructure\Repository\Loan\Term\LoanTermRepositoryInterface;
use Lendable\Interview\Util\MoneyConverter;
use Money\Money;

final readonly class LoanFeeCalculatorService implements LoanFeeCalculatorInterface
{
    public function __construct(
        private LoanTermRepositoryInterface  $loanTermRepository,
        private LoanFeeInterpolatorInterface $interpolator,
        private int $roundingInterval = 5 // in major units (e.g., £5)
    ) {
    }

    public function calculate(LoanApplication $loanApplication): Money
    {
        $loanAmount = $loanApplication->getAmount();
        $breakpoints = $this->loanTermRepository->getBreakpointsForTerm($loanApplication->getTerm());
        $interpolatedFee = $this->interpolatedFee($loanAmount, $breakpoints);

        return $this->roundedFee($loanAmount, $interpolatedFee);
    }

    /**
     * Calculate the interpolated fee based on the loan amount and breakpoints.
     * @param Money $loanAmount The loan amount requested
     * @param LoanTermBreakPoints $breakpoints The breakpoints for interpolation.
     * @return Money The interpolated fee as a Money object.
     */
    private function interpolatedFee(Money $loanAmount, LoanTermBreakpoints $breakpoints): Money
    {
        $amountAsFloat = MoneyConverter::toFloat($loanAmount);
        $feeAsFloat = $this->interpolator->interpolate($amountAsFloat, $breakpoints->all());

        return MoneyConverter::parseFloat($feeAsFloat);
    }

    /**
     * Rounds the fee up to the nearest specified interval.
     * E.g., if the interval is £5, a fee of £12.34 would be rounded up to £15.00.
     * @param Money $loanAmount The original loan amount.
     * @param Money $fee The interpolated fee before rounding.
     * @return Money The rounded fee as a Money object.
     */
    private function roundedFee(Money $loanAmount, Money $fee): Money
    {
        $interval = MoneyConverter::parseFloat($this->roundingInterval)->getAmount(); // to pence
        $total = (int) $loanAmount->getAmount() + (int) $fee->getAmount();
        $remainder = $total % $interval;

        if ($remainder !== 0) {
            $fee = MoneyConverter::parseFloat(($fee->getAmount() + ($interval - $remainder)) / 100);
        }

        return $fee;
    }
}
