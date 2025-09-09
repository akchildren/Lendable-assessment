<?php

namespace Lendable\Interview\Domain\Loan;

use Lendable\Interview\Exception\Loan\Term\LoanTermBreakpointsUndefinedException;

final readonly class LoanTermBreakpoints implements DomainModelInterface
{
    /**
     * @var array<int, int>
     */
    public array $breakpoints;

    /**
     * @param array<int, int> $breakpoints [amount => fee]
     */
    public function __construct(array $breakpoints)
    {
        ksort($breakpoints);
        $this->breakpoints = $breakpoints;
    }

    /**
     * @return array<int, int>
     */
    public function all(): array
    {
        return $this->breakpoints;
    }
}
