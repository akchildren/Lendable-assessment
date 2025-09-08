<?php

namespace Lendable\Interview\Repository\Loan\Term;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Exception\Loan\Term\LoanTermBreakpointsUndefinedException;

abstract class AbstractLoanTermRepository implements LoanTermRepositoryInterface
{
    /**
     * Implementations must fetch breakpoints from a persistence layer
     *
     * @return array<int, int> [amount => fee]
     */
    abstract protected function fetchBreakpoints(LoanTerm $term): ?array;

    /**
     * Get all breakpoints for a given term duration in key sorted order ASC
     * @throws LoanTermBreakpointsUndefinedException
     */
    final public function getBreakpointsForTerm(LoanTerm $term): array
    {
        $breakpoints = $this->fetchBreakpoints($term);

        if ($breakpoints === null) {
            throw new LoanTermBreakpointsUndefinedException($term);
        }

        ksort($breakpoints);

        return $breakpoints;
    }
}
