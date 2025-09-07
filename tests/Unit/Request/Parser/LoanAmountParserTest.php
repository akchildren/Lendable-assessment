<?php

namespace Lendable\Interview\Unit\Request\Parser;

use Lendable\Interview\Request\Loan\Parser\LoanAmountParser;
use Money\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LoanAmountParserTest extends TestCase
{
    #[DataProvider('validAmountProvider')]
    public function testParsesValidAmounts(string|float|int $input, int $expectedPence): void
    {
        $parser = new LoanAmountParser($input);
        $amount = $parser->parse();

        $this->assertInstanceOf(Money::class, $amount);
        $this->assertEquals($expectedPence, $amount->getAmount());
    }

    public static function validAmountProvider(): array
    {
        return [
            'formatted string' => ['1,234.56', 123456],
            'unformatted string' => ['1234.56', 123456],
            'integer string' => ['1234', 123400],
            'float' => [1234.56, 123456],
            'integer' => [1234, 123400],
        ];
    }
}
