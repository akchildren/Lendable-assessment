<?php
declare(strict_types=1);

namespace Lendable\Interview\Request\Loan\Validator;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Exception\Validator\ValidationException;
use Lendable\Interview\Request\ValidatorInterface;

final readonly class LoanTermValidator implements ValidatorInterface
{
    public function __construct(private mixed $term)
    {
    }

    public function validate(): void
    {
        if (is_null($this->term)) {
            throw new ValidationException('Term is required');
        }

        $term = (int) filter_var($this->term, FILTER_VALIDATE_INT);

        // If the term is not allowed, throw a general ValidationException
        if (!LoanTerm::tryFrom($term)) {
            throw new ValidationException(
                sprintf(
                    'Term must be one of the following values: %s. %s was given',
                    implode(', ', array_map(fn ($e) => $e->value, LoanTerm::cases())),
                    $term
                )
            );
        }
    }
}
