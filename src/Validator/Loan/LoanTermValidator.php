<?php

namespace Lendable\Interview\Validator\Loan;

use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;
use Lendable\Interview\Exception\Loan\Term\LoanTermInvalidException;
use Lendable\Interview\Exception\Validator\ValidationException;
use Lendable\Interview\Validator\Validator;

final class LoanTermValidator implements Validator
{
    public function __construct(
        private mixed $term = null,
    ) {
    }
    public function validate(): static
    {
        if (is_null($this->term)) {
            throw new ValidationException('Term is required');
        }

        $term = (int) filter_var($this->term, FILTER_VALIDATE_INT);

        if (! $this->term = LoanTermDuration::tryFrom($term)) {
            throw new LoanTermInvalidException($this->term);
        }

        return $this;
    }

    public function safe(): array
    {
        return [
            'term' => $this->term,
        ];
    }
}
