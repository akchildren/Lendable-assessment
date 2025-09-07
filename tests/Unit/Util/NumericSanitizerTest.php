<?php

namespace Lendable\Interview\Unit\Util;

use Lendable\Interview\Util\NumericSanitizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class NumericSanitizerTest extends TestCase
{
    #[DataProvider('floatStringProvider')]
    public function testSanitizeFloatString(
        string $input,
        float  $expected,
        string $thousandSep = ',',
        string $decimalSep = '.'
    ): void {
        $result = NumericSanitizer::sanitizeFloatString($input, $thousandSep, $decimalSep);
        $this->assertEquals($expected, $result);
    }

    public static function floatStringProvider(): array
    {
        return [
            'standard comma' => ['1,234.56', 1234.56],
            'custom decimal' => ['1.234,56', 1234.56, '.', ','],
            'no separators' => ['1234.56', 1234.56],
            'integer string' => ['1234', 1234.0],
            'spaces as thousand sep' => ['1 234,56', 1234.56, ' ', ','],
        ];
    }
}
