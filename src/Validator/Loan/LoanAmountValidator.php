<?php

namespace Lendable\Interview\Validator\Loan;

use Lendable\Interview\Exception\Validator\ValidationException;
use Lendable\Interview\Helper\MoneyHelper;
use Lendable\Interview\Helper\StringHelper;
use Lendable\Interview\Validator\Validator;

final class LoanAmountValidator implements Validator
{
    public function __construct(
        private ?string $amount = null,
    ) {
    }
    public function validate(): static
    {
        if (is_null($this->amount)) {
            throw new ValidationException('Amount is required');
        }

        $minAmount = round($_ENV['MIN_AMOUNT'] ?? 1000, 2);
        $maxAmount = round($_ENV['MAX_AMOUNT'] ?? 20000, 2);

        $this->amount = StringHelper::sanitiseFloatString($this->amount);

        if ($this->amount < $minAmount || $this->amount > $maxAmount) {
            throw new ValidationException(
                sprintf(
                    'Amount must be between %d and %d. %s was given',
                    $minAmount,
                    $maxAmount,
                    $this->amount
                )
            );
        }

        return $this;
    }

    public function safe(): array
    {
        return [
            'amount' => MoneyHelper::parseFloat($this->amount),
        ];
    }
}
