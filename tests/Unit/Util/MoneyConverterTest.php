<?php

namespace Lendable\Interview\Unit\Util;

use Lendable\Interview\Util\MoneyConverter;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MoneyConverterTest extends TestCase
{
    #[DataProvider('parseFloatProvider')]
    public function testParseFloat(float $input, int $expectedPence, string $currency = 'GBP'): void
    {
        $money = MoneyConverter::parseFloat($input, $currency);

        $this->assertInstanceOf(Money::class, $money);
        $this->assertEquals($expectedPence, $money->getAmount());
        $this->assertEquals($currency, $money->getCurrency()->getCode());
    }

    #[DataProvider('toFloatProvider')]
    public function testToFloat(
        int    $amountInPence,
        float  $expectedFloat,
        string $currency = 'GBP'
    ): void
    {
        $money = new Money($amountInPence, new Currency($currency));
        $float = MoneyConverter::toFloat($money);

        $this->assertEquals($expectedFloat, $float);
    }

    /**
     * @return array<string, list<float|int|string>>
     */
    public static function parseFloatProvider(): array
    {
        return [
            'simple' => [1234.56, 123456],
            'rounded up' => [1234.567, 123457],
            'zero' => [0.0, 0],
        ];
    }

    /**
     * @return array<string, list<int|float>>
     */
    public static function toFloatProvider(): array
    {
        return [
            'standard' => [123456, 1234.56],
            'zero' => [0, 0.0],
            'small amount' => [1, 0.01],
        ];
    }
}
