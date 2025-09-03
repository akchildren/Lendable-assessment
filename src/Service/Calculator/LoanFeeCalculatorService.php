<?php

namespace Lendable\Interview\Service\Calculator;

use Lendable\Interview\DataTransferObject\Loan\LoanRequestData;
use Lendable\Interview\DataTransferObject\Loan\LoanTotalResponseData;
use Lendable\Interview\Service\Breakpoint\TermBreakpointService;
use Money\Money;

final readonly class LoanFeeCalculatorService
{
    public function __construct(
        private TermBreakpointService $termBreakpointService,
        private int                   $roundingFeeInterval = 5
    )
    {
    }

    public function execute(LoanRequestData $loanData): LoanTotalResponseData
    {
        $breakpoints = $this->termBreakpointService->getSortedBreakdownForTerm($loanData->getTerm());

        $loanAmountInPence = (int)$loanData->getAmount()->getAmount();
        $fee = $this->findBreakpointFee($loanAmountInPence, $breakpoints);

        return new LoanTotalResponseData(
            amount: $loanData->getAmount(),
            fee: new Money(
                $this->roundFeeUpToNearestInterval($loanAmountInPence, $fee),
                $loanData->getAmount()->getCurrency()
            ),
        );
    }

    private function findBreakpointFee(int $loanAmountInPence, array $breakpoints): int
    {
        $keys = array_keys($breakpoints);
        $lowerAmount = null;
        $upperAmount = null;

        foreach ($keys as $key) {
            if ($key < $loanAmountInPence) {
                $lowerAmount = $key;
            }
            if ($key > $loanAmountInPence && $lowerAmount !== null) {
                $upperAmount = $key;
                break;
            }
        }

        $feeLower = $breakpoints[$lowerAmount];
        $feeUpper = $breakpoints[$upperAmount];

        // Linear interpolation formula:
        $fee = $feeLower +
            (($loanAmountInPence - $lowerAmount) /
                ($upperAmount - $lowerAmount)) *
            ($feeUpper - $feeLower);
        return round($fee, 2);
    }

    private function roundFeeUpToNearestInterval(
        int $loanAmountInPence,
        int $feeInPence
    ): int
    {
        $totalInPence = $loanAmountInPence + $feeInPence;
        $remainder = $totalInPence % $this->roundingFeeInterval;
        if ($remainder !== 0) {
            $feeInPence += $this->roundingFeeInterval - $remainder;
        }
        return $feeInPence;
    }
}