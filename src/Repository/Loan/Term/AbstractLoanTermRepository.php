<?php

namespace Lendable\Interview\Repository\Loan\Term;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Exception\Loan\Term\LoanTermBreakpointsUndefinedException;

abstract readonly class AbstractLoanTermRepository implements LoanTermRepositoryInterface
{
    /**
     * @var array<int, array<int, int>>  // [LoanTerm->value => [amount => fee]]
     */
    protected array $breakpoints;

    /**
     * @param array<int, array<int, int>> $breakpoints
     */
    public function __construct(array $breakpoints)
    {
        $this->breakpoints = $breakpoints;
    }

    public function getBreakpointsForTerm(LoanTerm $term): array
    {
        if (!isset($this->breakpoints[$term->value])) {
            throw new LoanTermBreakpointsUndefinedException($term);
        }
        $breakpoints = $this->breakpoints[$term->value];
        ksort($breakpoints);
        return $breakpoints;
    }
}
