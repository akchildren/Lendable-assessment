<?php

namespace Lendable\Interview\Request;

use Lendable\Interview\Exception\Validator\ValidationException;

interface RequestInterface
{
    /**
     * Validate the request input.
     *
     * @return static Fluent interface
     * @throws ValidationException
     */
    public function validate(): static;

    /**
     * Return normalized, domain-ready data.
     *
     * @return array<string, mixed>
     */
    public function safe(): array;
}
