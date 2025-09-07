<?php

namespace Lendable\Interview\Repository\Loan\Term;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;

interface LoanTermRepositoryInterface
{
    /**
     * Get all breakpoints for a given term duration in sorted order
     *
     * @param LoanTerm $term
     * @return array<int, int>
     */
    public function getBreakpointsForTerm(LoanTerm $term): array;

    /**
     * Get fee for a specific amount and term
     *
     * @param int $amount
     * @param LoanTerm $term
     * @return int|null Returns null if not found
     */
    public function getFee(int $amount, LoanTerm $term): ?int;

    /**
     * Check if a given amount is valid for a term
     *
     * @param int $amount
     * @param LoanTerm $term
     * @return bool
     */
    public function isValidAmountForTerm(int $amount, LoanTerm $term): bool;
}
