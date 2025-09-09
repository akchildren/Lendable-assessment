<?php

declare(strict_types=1);

namespace Lendable\Interview\Unit\Application\Service\Loan\Fee;

use InvalidArgumentException;
use Lendable\Interview\Application\Service\Loan\Fee\LoanFeeInterpolatorService;
use PHPUnit\Framework\TestCase;

final class LoanFeeInterpolatorServiceTest extends TestCase
{
    private LoanFeeInterpolatorService $interpolator;

    protected function setUp(): void
    {
        $this->interpolator = new LoanFeeInterpolatorService();
    }

    public function testInterpolatesCorrectlyBetweenTwoBreakpoints(): void
    {
        $loanAmount = 12500.00;
        $breakpoints = [
            10000 => 300,
            15000 => 500
        ];

        // Expected interpolation: 300 + ((12500 - 10000) / 5000) * (500 - 300) = 400
        $this->assertEquals(
            400.00,
            $this->interpolator->interpolate($loanAmount, $breakpoints)
        );
    }

    public function testReturnsExactFeeIfLoanMatchesBreakpoint(): void
    {
        $loanAmount = 10000.00;
        $breakpoints = [
            10000 => 275,
            15000 => 400
        ];

        $this->assertEquals(
            275.00,
            $this->interpolator->interpolate($loanAmount, $breakpoints)
        );
    }

    public function testThrowsExceptionIfLoanAmountOutOfBounds(): void
    {
        $loanAmount = 9000.00;
        $breakpoints = [
            10000 => 300,
            15000 => 500
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->interpolator->interpolate($loanAmount, $breakpoints);
    }

    public function testThrowsExceptionIfUpperBoundNotFound(): void
    {
        $loanAmount = 16000.00;
        $breakpoints = [
            10000 => 300,
            15000 => 500
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->interpolator->interpolate($loanAmount, $breakpoints);
    }

    public function testInterpolationWithNonRoundBreakpoints(): void
    {
        $loanAmount = 11250.00;
        $breakpoints = [
            10000 => 305,
            12500 => 455,
            15000 => 600
        ];

        // Linear interpolation: 305 + ((11250 - 10000)/2500) * (455 - 305) = 305 + 0.5 * 150 = 380
        $this->assertEquals(
            380.00,
            $this->interpolator->interpolate($loanAmount, $breakpoints)
        );
    }
}
