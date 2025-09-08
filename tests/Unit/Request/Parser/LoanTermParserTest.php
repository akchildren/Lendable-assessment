<?php
declare(strict_types=1);

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

    /**
     * @return array<string, list<int|LoanTerm|string>>
     */
    public static function validTermProvider(): array
    {
        return [
            'TWELVE MONTH string' => ['12', LoanTerm::TWELVE_MONTH],
            'TWENTY FOUR MONTH string' => ['24', LoanTerm::TWENTY_FOUR_MONTH],
            'annual int' => [12, LoanTerm::TWELVE_MONTH],
            'biannual int' => [24, LoanTerm::TWENTY_FOUR_MONTH],
        ];
    }
}
