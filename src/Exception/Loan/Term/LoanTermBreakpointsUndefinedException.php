<?php

namespace Lendable\Interview\Exception\Loan\Term;

use InvalidArgumentException;
use Lendable\Interview\Enum\Loan\Term\LoanTerm;

final class LoanTermBreakpointsUndefinedException extends InvalidArgumentException
{
    public function __construct(LoanTerm $term)
    {
        parent::__construct(
            sprintf(
                'Breakpoint data is not defined for the term: %s',
                $term->value
            )
        );
    }
}
