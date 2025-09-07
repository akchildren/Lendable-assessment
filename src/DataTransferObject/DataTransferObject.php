<?php

namespace Lendable\Interview\DataTransferObject;

interface DataTransferObject
{
    /**
     * Convert the DTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
