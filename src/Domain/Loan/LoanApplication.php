<?php

namespace Lendable\Interview\Domain\Loan;

use Lendable\Interview\Domain\DomainModelInterface;
use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Money\Money;

final readonly class LoanApplication implements DomainModelInterface
{
    public function __construct(
        private Money    $amount,
        private LoanTerm $term
    ) {
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getTerm(): LoanTerm
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
