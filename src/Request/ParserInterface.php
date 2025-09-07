<?php

namespace Lendable\Interview\Request;

interface ParserInterface
{
    /**
     * Normalizes raw input into a domain-friendly value.
     *
     * @return mixed Domain object (e.g., Money, LoanTerm)
     */
    public function parse(): mixed;
}
