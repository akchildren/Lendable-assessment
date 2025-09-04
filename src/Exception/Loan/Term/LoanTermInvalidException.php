<?php

namespace Lendable\Interview\Exception\Loan\Term;

use InvalidArgumentException;
use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;

final class LoanTermInvalidException extends InvalidArgumentException
{
    public function __construct(int $term)
    {
        parent::__construct(
            sprintf(
                'Term must be one of the following values: %s. %s was given',
                implode(', ', array_map(fn ($case) => $case->value, LoanTermDuration::cases())),
                $term
            )
        );
    }
}
