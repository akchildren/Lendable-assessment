<?php
declare(strict_types=1);

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
}
