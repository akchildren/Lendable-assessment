<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Config;

/**
 * Configuration class to access environment variables with defaults.
 * @note This implementation assumes that environment variables are provided as an associative array.
 */
final readonly class Config implements ConfigInterface
{
    /**
     * @param array<string, string> $env
     */
    public function __construct(private array $env)
    {
    }

    public function getMinAmount(): string
    {
        return $this->env['MIN_LOAN_AMOUNT'] ?? '1000';
    }

    public function getMaxAmount(): string
    {
        return $this->env['MAX_LOAN_AMOUNT'] ?? '20000';
    }

    public function getRoundingInterval(): string
    {
        return $this->env['FEE_ROUNDING_INTERVAL'] ?? '5';
    }

    public function getCurrency(): string
    {
        return $this->env['DEFAULT_CURRENCY'] ?? 'GBP';
    }
}
