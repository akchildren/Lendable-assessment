<?php

namespace Lendable\Interview\Request\Loan\Parser;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Request\ParserInterface;

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
