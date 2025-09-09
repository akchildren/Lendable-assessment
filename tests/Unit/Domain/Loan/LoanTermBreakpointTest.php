<?php

declare(strict_types=1);

namespace Lendable\Interview\Unit\Domain\Loan;

use Lendable\Interview\Domain\Loan\LoanTermBreakpoints;
use PHPUnit\Framework\TestCase;

final class LoanTermBreakpointTest extends TestCase
{
    public function test_it_returns_breakpoints_as_passed_when_already_sorted(): void
    {
        $input = [
            1000 => 50,
            2000 => 90,
            3000 => 120,
        ];

        $breakpoints = new LoanTermBreakpoints($input);

        $this->assertSame($input, $breakpoints->all());
    }

    public function test_it_sorts_breakpoints_by_key_when_unsorted(): void
    {
        $input = [
            3000 => 120,
            1000 => 50,
            2000 => 90,
        ];

        $expected = [
            1000 => 50,
            2000 => 90,
            3000 => 120,
        ];

        $breakpoints = new LoanTermBreakpoints($input);

        $this->assertSame($expected, $breakpoints->all());
    }

    public function test_it_handles_empty_breakpoints(): void
    {
        $breakpoints = new LoanTermBreakpoints([]);

        $this->assertSame([], $breakpoints->all());
    }
}
