<?php

namespace Lendable\Interview\DataTransferObject\Loan;

use Lendable\Interview\DataTransferObject\DataTransferObject;
use Money\Money;

final readonly class LoanFeeData implements DataTransferObject
{
    public function __construct(
        private Money $amountRequested,
        private Money $fee,
    ) {
    }

    public function getAmountRequested(): Money
    {
        return $this->amountRequested;
    }

    public function getFee(): Money
    {
        return $this->fee;
    }

    public function getFormattedFee(): string
    {
        return number_format(
            bcdiv($this->fee->getAmount(), '100', 2),
            2
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amountRequested,
            'fee' => $this->fee,
        ];
    }
}
