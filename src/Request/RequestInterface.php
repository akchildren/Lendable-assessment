<?php

namespace Lendable\Interview\Request;

use Lendable\Interview\Exception\Validator\ValidationException;

interface RequestInterface
{
    /**
     * Validate the request input.
     *
     * @throws ValidationException
     */
    public function validate(): static;

    /**
     * Return parsed, domain-ready data.
     *
     * @return array<string, mixed>
     */
    public function safe(): array;
}
