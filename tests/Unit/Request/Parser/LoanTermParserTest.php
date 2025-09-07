<?php

namespace Lendable\Interview\Unit\Request\Parser;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Request\Loan\Parser\LoanTermParser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LoanTermParserTest extends TestCase
{
    #[DataProvider('validTermProvider')]
    public function testParsesValidTerms(int|string $input, LoanTerm $expectedTerm): void
    {
        $parser = new LoanTermParser($input);
        $term = $parser->parse();

        $this->assertEquals($expectedTerm, $term);
    }

    public static function validTermProvider(): array
    {
        return [
            'annual string' => ['12', LoanTerm::ANNUAL],
            'biannual string' => ['24', LoanTerm::BIANNUAL],
            'annual int' => [12, LoanTerm::ANNUAL],
            'biannual int' => [24, LoanTerm::BIANNUAL],
        ];
    }
}
