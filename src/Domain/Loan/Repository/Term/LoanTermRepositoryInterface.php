<?php

declare(strict_types=1);

namespace Lendable\Interview\Domain\Loan\Repository\Term;

use Lendable\Interview\Domain\Loan\LoanTerm;
use Lendable\Interview\Domain\Loan\LoanTermBreakpoints;

interface LoanTermRepositoryInterface
{
    /**
     * Get all breakpoints for a given term duration in sorted order
     */
    public function getBreakpointsForTerm(LoanTerm $term): LoanTermBreakpoints;
}
