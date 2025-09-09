<?php

declare(strict_types=1);

namespace Lendable\Interview\Exception\Loan\Term;

use InvalidArgumentException;
use Lendable\Interview\Domain\Loan\LoanTerm;

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
