<?php

declare(strict_types=1);

namespace Lendable\Interview\Application\Request;

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
