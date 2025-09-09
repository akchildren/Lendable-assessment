<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Request\Loan\Parser;

use Lendable\Interview\Application\Request\ParserInterface;
use Lendable\Interview\Domain\Loan\LoanTerm;

/**
 * Parses raw loan term input into a LoanTerm enum.
 */
final readonly class LoanTermParser implements ParserInterface
{
    public function __construct(
        private mixed $rawTerm,
    ) {
    }

    public function parse(): LoanTerm
    {
        $term = (int) filter_var($this->rawTerm, FILTER_VALIDATE_INT);
        return  LoanTerm::from($term);
    }
}
