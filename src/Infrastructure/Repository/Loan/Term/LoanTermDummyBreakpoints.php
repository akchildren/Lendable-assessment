<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Repository\Loan\Term;

use Lendable\Interview\Domain\Loan\LoanTerm;

/**
 * This class holds the breakpoints for different loan terms.
 * The breakpoints define the interest rates based on the loan amount and term.
 * @note This is strictly static data representation.
 * @see LoanTerm
 */
final readonly class LoanTermDummyBreakpoints
{
    /**
     * @var array<int, array<int, int>>
     */
    public const array DATA = [
        LoanTerm::TWELVE_MONTH->value => [
            1000 => 50,
            2000 => 90,
            3000 => 90,
            4000 => 115,
            5000 => 100,
            6000 => 120,
            7000 => 140,
            8000 => 160,
            9000 => 180,
            10000 => 200,
            11000 => 220,
            12000 => 240,
            13000 => 260,
            14000 => 280,
            15000 => 300,
            16000 => 320,
            17000 => 340,
            18000 => 360,
            19000 => 380,
            20000 => 400,
        ],
        LoanTerm::TWENTY_FOUR_MONTH->value => [
            1000 => 70,
            2000 => 100,
            3000 => 120,
            4000 => 160,
            5000 => 200,
            6000 => 240,
            7000 => 280,
            8000 => 320,
            9000 => 360,
            10000 => 400,
            11000 => 440,
            12000 => 480,
            13000 => 520,
            14000 => 560,
            15000 => 600,
            16000 => 640,
            17000 => 680,
            18000 => 720,
            19000 => 760,
            20000 => 800,
        ],
    ];
}
