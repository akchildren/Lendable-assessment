<?php

namespace Lendable\Interview\Exception\Loan;

use InvalidArgumentException;
use Lendable\Interview\Enum\Term\TermDuration;

final class LoanTermBreakpointsUndefinedException extends InvalidArgumentException
{
    public function __construct(TermDuration $term)
    {
        parent::__construct(
            sprintf(
                'Breakpoint data is not defined for the term: %s',
                $term->value
            )
        );
    }
}
