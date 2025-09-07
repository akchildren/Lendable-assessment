<?php

namespace Lendable\Interview\Request;

use Lendable\Interview\Exception\Validator\ValidationException;

interface ValidatorInterface
{
    /**
     * Validate the request input.
     *
     * @throws ValidationException
     */
    public function validate(): void;
}
