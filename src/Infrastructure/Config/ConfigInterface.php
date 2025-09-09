<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Config;

interface ConfigInterface
{
    /**
     * Get the minimum loan amount from configuration.
     * @return string The minimum loan amount as a string.
     * @note This should be less than or equal to the maximum amount.
     */
    public function getMinAmount(): string;

    /**
     * Get the maximum loan amount from configuration.
     * @return string The maximum loan amount as a string.
     * @note This should be greater than or equal to the minimum amount.
     */
    public function getMaxAmount(): string;

    /**
     * Get the fee rounding interval from configuration.
     * @return string The fee rounding interval as a string.
     * @note This should be a positive number representing the rounding step (e.g., '5' for rounding to the nearest 5).
     */
    public function getRoundingInterval(): string;

    /**
     * Get the default currency code from the configuration.
     * @return string The default currency code (e.g., 'GBP').
     * @note This should be a valid ISO 4217 currency code.
     */
    public function getCurrency(): string;
}
