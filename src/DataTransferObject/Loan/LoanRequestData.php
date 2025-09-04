<?php

namespace Lendable\Interview\DataTransferObject\Loan;

use Lendable\Interview\DataTransferObject\DataTransferObject;
use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;
use Lendable\Interview\Helper\MoneyHelper;
use Money\Money;

final readonly class LoanRequestData implements DataTransferObject
{
    public function __construct(
        private Money $amount,
        private LoanTermDuration $term,
    ) {
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getAmountInPence(): int
    {
        return (int) $this->amount->getAmount();
    }

    public function getAmountInPounds(): float
    {
        return MoneyHelper::toFloat($this->amount);
    }

    public function getTerm(): LoanTermDuration
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
