<?php

namespace Lendable\Interview\Service\Breakpoint;

use Lendable\Interview\Enum\Term\TermDuration;
use Lendable\Interview\Exception\Loan\LoanTermBreakpointsUndefinedException;

abstract class TermBreakpointService
{
    /**
     * @var array<int, array<int, int>>
     */
    public function __construct(
        private array $breakpoints
    )
    {
    }

    public function getSortedBreakdownForTerm(TermDuration $term): array
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