<?php
declare(strict_types=1);

namespace Lendable\Interview\Request\Loan\Parser;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Request\ParserInterface;

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
