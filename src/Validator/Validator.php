<?php

namespace Lendable\Interview\Validator;

interface Validator
{
    public function validate(): static;

    public function safe(): array;
}
