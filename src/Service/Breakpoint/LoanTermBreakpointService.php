<?php

namespace Lendable\Interview\Service\Breakpoint;

use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;
use Lendable\Interview\Exception\Loan\LoanTermBreakpointsUndefinedException;

abstract class LoanTermBreakpointService
{
    /**
     * @var array<int, array<int, int>>
     */
    public function __construct(
        private array $breakpoints
    ) {
    }

    public function getSortedBreakdownForTerm(LoanTermDuration $term): array
    {
        if (
            ! isset($this->breakpoints[$term->value])
            || empty($this->breakpoints[$term->value])
            || ! is_array($this->breakpoints[$term->value])
        ) {
            throw new LoanTermBreakpointsUndefinedException($term);
        }

        /**
         * @note it is not always guaranteed breakpoint key amounts are in sorted order.
         */
        ksort($this->breakpoints[$term->value]);

        return $this->breakpoints[$term->value];
    }
}
