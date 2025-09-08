<?php

namespace Lendable\Interview\Domain;

interface DomainModelInterface
{
    /**
     * Returns the domain object as an array.
     *
     * Useful for serialization, logging, or testing.
     */
    public function toArray(): array;
}
