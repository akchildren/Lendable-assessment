<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Request\Loan;

use Lendable\Interview\Application\Request\Loan\Parser\LoanAmountParser;
use Lendable\Interview\Application\Request\Loan\Parser\LoanTermParser;
use Lendable\Interview\Application\Request\Loan\Validator\LoanAmountValidator;
use Lendable\Interview\Application\Request\Loan\Validator\LoanTermValidator;
use Lendable\Interview\Application\Request\RequestInterface;

/**
 * Loan application request handler.
 *
 * This class is responsible for validating and parsing loan application data.
 * It uses specific validators and parsers for the amount and term fields.
 */
final readonly class LoanApplicationRequest implements RequestInterface
{
    /**
     * @var array <string, mixed> List of validators to be applied to the request data.
     */
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
