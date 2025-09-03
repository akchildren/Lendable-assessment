<?php

namespace Lendable\Interview\DataTransferObject\Loan;

use Lendable\Interview\DataTransferObject\DataTransferObject;
use Money\Money;

final readonly class LoanTotalResponseData implements DataTransferObject
{
    public function __construct(
        private Money $amount,
        private Money $fee,
    ) {
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getFee(): Money
    {
        return $this->fee;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'fee' => $this->fee,
        ];
    }
}
