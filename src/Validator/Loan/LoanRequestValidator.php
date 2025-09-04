<?php

namespace Lendable\Interview\Validator\Loan;

use Lendable\Interview\Validator\Validator;

final class LoanRequestValidator implements Validator
{
    public function __construct(
        private mixed $amount = null,
        private mixed $term = null,
    ) {
    }
    public function validate(): static
    {
        $this->amount = new LoanAmountValidator($this->amount)->validate()->safe()['amount'];
        $this->term = new LoanTermValidator($this->term)->validate()->safe()['term'];
        return $this;
    }

    public function safe(): array
    {
        return [
            'amount' => $this->amount,
            'term' => $this->term,
        ];
    }
}
