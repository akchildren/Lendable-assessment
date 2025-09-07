<?php

namespace Lendable\Interview\DataTransferObject\Loan;

use Lendable\Interview\DataTransferObject\DataTransferObject;
use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Money\Money;

/**
 * Data Transfer Object for Loan Application Request
 */
final readonly class LoanApplicationRequestDto implements DataTransferObject
{
    public function __construct(
        public Money $amount,
        public LoanTerm $term
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data['amount'],
            term: $data['term']
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'term' => $this->term,
        ];
    }
}
