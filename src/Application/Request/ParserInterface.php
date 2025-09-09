<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Request;

interface ParserInterface
{
    /**
     * Parses raw input into a domain-friendly value.
     *
     * @return mixed Domain object (e.g., Money, LoanTerm)
     */
    public function parse(): mixed;
}
