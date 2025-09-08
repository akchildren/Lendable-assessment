<?php

namespace Lendable\Interview\Domain;

interface DomainModelInterface
{
    /**
     * Returns the domain object as an array
     * Useful for serialization, logging, or testing.
     *
     * @return array<string, mixed> Associative array representation of the domain object.
     */
    public function toArray(): array;
}
