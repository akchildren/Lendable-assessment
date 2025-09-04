<?php

namespace Lendable\Interview\Unit\Command;

use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;
use PHPUnit\Framework\TestCase;

final class CalculateFeeCommandTest extends TestCase
{
    private const string PHP_BIN_CALCULATE_FEE = 'php bin/calculate-fee';

    public function test_calculate_fee_command_annual_success(): void
    {
        $this->assertStringContainsString(
            '385.00',
            shell_exec(self::getCommandString('19,250.00', LoanTermDuration::ANNUAL->value))
        );
    }

    public function test_calculate_fee_command_biannual_success(): void
    {
        $this->assertStringContainsString(
            '460.00',
            shell_exec(self::getCommandString('11,500.00', LoanTermDuration::BIANNUAL->value))
        );
    }

    public function test_calculate_fee_command_can_parse_non_formatted_float_success(): void
    {
        $this->assertStringContainsString(
            '460.00',
            shell_exec(self::getCommandString('11500.00', LoanTermDuration::BIANNUAL->value))
        );
    }

    public function test_calculate_fee_command_can_parse_unsigned_integer_success(): void
    {
        $this->assertStringContainsString(
            '460.00',
            shell_exec(self::getCommandString('11500', LoanTermDuration::BIANNUAL->value))
        );
    }

    private static function getCommandString(string $amount, string $term): string
    {
        return sprintf('%s %s %s',
            self::PHP_BIN_CALCULATE_FEE,
            $amount,
            $term
        );
    }
}