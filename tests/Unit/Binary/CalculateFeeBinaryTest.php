<?php
declare(strict_types=1);

namespace Lendable\Interview\Unit\Binary;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CalculateFeeBinaryTest extends TestCase
{
    private const string PHP_BIN_CALCULATE_FEE = 'php bin/calculate-fee';

    #[DataProvider('feeCommandProvider')]
    public function testCalculateFeeCommandSuccess(string $amount, int $term, string $expectedOutput): void
    {
        $command = self::getCommandString($amount, $term);
        $output = shell_exec($command);

        $this->assertStringContainsString($expectedOutput, $output);
    }

    /**
     * @return array<string, array{0: string, 1: int, 2: string}>
     */
    public static function feeCommandProvider(): array
    {
        return [
            'Example: TWELVE MONTH 19,250.00' => ['19,250.00', LoanTerm::TWELVE_MONTH->value, '385.00'],
            'Example: TWENTY FOUR MONTH 11,500.00' => ['11,500.00', LoanTerm::TWENTY_FOUR_MONTH->value, '460.00'],
            'Standard Float' => ['11500.00', LoanTerm::TWENTY_FOUR_MONTH->value, '460.00'],
            'Integer' => ['11500', LoanTerm::TWENTY_FOUR_MONTH->value, '460.00'],
        ];
    }

    private static function getCommandString(string $amount, int $term): string
    {
        return sprintf('%s %s %s', self::PHP_BIN_CALCULATE_FEE, $amount, $term);
    }
}
