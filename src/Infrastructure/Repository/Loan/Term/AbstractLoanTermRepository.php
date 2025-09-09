<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Repository\Loan\Term;

use Lendable\Interview\Domain\Loan\LoanTerm;
use Lendable\Interview\Domain\Loan\LoanTermBreakpoints;
use Lendable\Interview\Domain\Loan\Repository\Term\LoanTermRepositoryInterface;
use Lendable\Interview\Exception\Loan\Term\LoanTermBreakpointsUndefinedException;

abstract class AbstractLoanTermRepository implements LoanTermRepositoryInterface
{
    /**
     * Implementations must fetch breakpoints from a persistence layer
     *
     * @return ?array<int, int> [amount => fee] or null if not found
     */
    abstract protected function fetchBreakpoints(LoanTerm $term): ?array;

    /**
     * Get all breakpoints for a given term duration in key sorted order ASC
     * @throws LoanTermBreakpointsUndefinedException
     */
    final public function getBreakpointsForTerm(LoanTerm $term): LoanTermBreakpoints
    {
        $breakpoints = $this->fetchBreakpoints($term);

        if ($breakpoints === null) {
            throw new LoanTermBreakpointsUndefinedException($term);
        }

        return new LoanTermBreakpoints($breakpoints);
    }
}
