<?php

declare(strict_types=1);

namespace Lendable\Interview\Unit\Infrastructure\Config;

use Lendable\Interview\Infrastructure\Config\Config;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    public function testDefaultsAreAppliedWhenEnvIsEmpty(): void
    {
        $config = new Config([]);

        self::assertSame('1000', $config->getMinAmount());
        self::assertSame('20000', $config->getMaxAmount());
        self::assertSame('5', $config->getRoundingInterval());
    }

    /**
     * @param array<string, string> $env
     */
    #[DataProvider('provideCustomEnvValues')]
    public function testCustomEnvValues(
        array  $env,
        string $expectedMin,
        string $expectedMax,
        string $expectedRounding
    ): void {
        $config = new Config($env);

        self::assertSame($expectedMin, $config->getMinAmount());
        self::assertSame($expectedMax, $config->getMaxAmount());
        self::assertSame($expectedRounding, $config->getRoundingInterval());
    }

    /**
     * @return array<string, list<array<string, string>|string>>
     */
    public static function provideCustomEnvValues(): array
    {
        return [
            'integer values' => [
                ['MIN_LOAN_AMOUNT' => '1500.20', 'MAX_LOAN_AMOUNT' => '30000.30', 'FEE_ROUNDING_INTERVAL' => '10'],
                '1500.20',
                '30000.30',
                '10',
            ],
            'string values (cast to numbers)' => [
                ['MIN_LOAN_AMOUNT' => '2500.50', 'MAX_LOAN_AMOUNT' => '40000', 'FEE_ROUNDING_INTERVAL' => '7'],
                '2500.50',
                '40000',
                '7',
            ]
        ];
    }
}
