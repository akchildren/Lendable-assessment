<?php
declare(strict_types=1);

namespace Lendable\Interview\Request\Loan\Validator;

use Lendable\Interview\Exception\Validator\ValidationException;
use Lendable\Interview\Request\ValidatorInterface;

final readonly class LoanAmountValidator implements ValidatorInterface
{
    public function __construct(
        private ?string $amount,
        private float $minAmount = 1000,
        private float $maxAmount = 20000
    ) {
    }

    public function validate(): void
    {
        if (is_null($this->amount)) {
            throw new ValidationException('Amount is required');
        }

        $amount = (float) str_replace(',', '', $this->amount);

        if ($amount < $this->minAmount || $amount > $this->maxAmount) {
            throw new ValidationException(
                sprintf(
                    'Amount must be between %s and %s. %s given',
                    $this->minAmount,
                    $this->maxAmount,
                    $amount
                )
            );
        }
    }
}
