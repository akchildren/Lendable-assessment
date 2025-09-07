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

    public function execute(LoanApplicationRequestDto $loanData): Money
    {
        $loanAmount = $loanData->amount;
        $term = $loanData->term;

        $breakpoints = $this->loanTermRepository->getBreakpointsForTerm($term);

        $interpolatedFee = $this->calculateInterpolatedFee($loanData, $breakpoints);
        return $this->roundFeeUpToNearestInterval($loanAmount, $interpolatedFee);
    }

    private function calculateInterpolatedFee(
        LoanApplicationRequestDto $loanData,
        array                     $breakpoints
    ): Money {
        $loanAmount = MoneyConverter::toFloat($loanData->amount);
        $interpolated = $this->interpolator->interpolate($loanAmount, $breakpoints);

        return MoneyConverter::parseFloat($interpolated);
    }

    /**
     * @note: This rounding logic will allow for decimal loan amount requests (e.g. £1000.50)
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
