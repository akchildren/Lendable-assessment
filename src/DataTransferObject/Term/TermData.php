<?php

namespace Lendable\Interview\DataTransferObject\Term;

use Lendable\Interview\DataTransferObject\DataTransferObject;
use Lendable\Interview\Enum\Term\TermDuration;

final readonly class TermData implements DataTransferObject
{
    public function __construct(
        private TermDuration $duration,
        private array $breakpoints,
    ) {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getFee(): int
    {
        return $this->fee;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'term' => $this->term,
        ];
    }
}
