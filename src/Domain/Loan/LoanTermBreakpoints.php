<?php

namespace Lendable\Interview\Domain\Loan;

use Lendable\Interview\Exception\Loan\Term\LoanTermBreakpointsUndefinedException;

final class LoanTermBreakpoints
{
    /**
     * @param array<int, int> $breakpoints [amount => fee]
     */
    public function __construct(
        private array $breakpoints
    ) {
        ksort($this->breakpoints);
    }

    /**
     * @return array<int, int>
     */
    public function all(): array
    {
        return $this->breakpoints;
    }
}
