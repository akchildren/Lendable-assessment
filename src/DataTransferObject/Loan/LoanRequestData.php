<?php

namespace Lendable\Interview\DataTransferObject\Loan;

use Lendable\Interview\DataTransferObject\DataTransferObject;
use Lendable\Interview\Enum\Term\TermDuration;
use Money\Money;

final readonly class LoanRequestData implements DataTransferObject
{
    public function __construct(
        private Money $amount,
        private TermDuration $term,
    ) {
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getTerm(): TermDuration
    {
        return $this->term;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'term' => $this->term,
        ];
    }
}
