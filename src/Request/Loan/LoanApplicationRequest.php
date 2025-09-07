<?php

namespace Lendable\Interview\Request\Loan;

use Lendable\Interview\Request\Loan\Parser\LoanAmountParser;
use Lendable\Interview\Request\Loan\Parser\LoanTermParser;
use Lendable\Interview\Request\Loan\Validator\LoanAmountValidator;
use Lendable\Interview\Request\Loan\Validator\LoanTermValidator;
use Lendable\Interview\Request\RequestInterface;

final readonly class LoanApplicationRequest implements RequestInterface
{
    private array $validators;

    public function __construct(
        private ?string $rawAmount,
        private mixed $rawTerm,
        private float $minAmount = 1000,
        private float $maxAmount = 20000,
    ) {
        // Only construct validators here
        $this->validators = [
            'amount' => new LoanAmountValidator(
                amount: $this->rawAmount,
                minAmount: $this->minAmount,
                maxAmount: $this->maxAmount
            ),
            'term' => new LoanTermValidator($this->rawTerm),
        ];
    }

    public function validate(): static
    {
        foreach ($this->validators as $validator) {
            $validator->validate();
        }

        return $this;
    }

    public function safe(): array
    {
        return [
            'amount' => new LoanAmountParser($this->rawAmount)->parse(),
            'term'   => new LoanTermParser($this->rawTerm)->parse(),
        ];
    }
}
