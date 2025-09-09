<?php

declare(strict_types=1);

namespace Lendable\Interview\Domain\Loan;

use Lendable\Interview\Domain\DomainModelInterface;
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
}
