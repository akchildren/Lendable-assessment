<?php

namespace Lendable\Interview\Validator;

use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;
use Lendable\Interview\Exception\Loan\InvalidLoanTermException;
use Lendable\Interview\Exception\Validator\ValidationException;
use Lendable\Interview\Helper\MoneyHelper;
use Lendable\Interview\Helper\StringHelper;

final class LoanRequestValidator implements Validator
{
    public function __construct(
        private ?string $amount = null,
        private mixed $term = null,
    ) {
    }
    public function validate(): static
    {
        self::validateAmount();
        self::validateTerm();

        return $this;
    }

    public function safe(): array
    {
        return [
            'amount' => MoneyHelper::parseFloat($this->amount),
            'term' => $this->term,
        ];
    }

    private function validateAmount(): void
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
    }

    private function validateTerm(): void
    {
        if (is_null($this->term)) {
            throw new ValidationException('Term is required');
        }

        $term = (int) filter_var($this->term, FILTER_VALIDATE_INT);

        if (! $this->term = LoanTermDuration::tryFrom($term)) {
            throw new InvalidLoanTermException($this->term);
        }
    }
}
