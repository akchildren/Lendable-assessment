<?php
declare(strict_types=1);

namespace Lendable\Interview\Unit\Repository;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Repository\Loan\Term\LoanTermDummyRepository;
use PHPUnit\Framework\TestCase;

final class LoanTermDummyRepositoryTest extends TestCase
{
    private LoanTermDummyRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new LoanTermDummyRepository();
    }

    public function testGetBreakpointsForValidAnnualTerm(): void
    {
        $breakpoints = $this->repository->getBreakpointsForTerm(LoanTerm::TWELVE_MONTH);

        $this->assertArrayHasKey(1000, $breakpoints);
        $this->assertEquals(50, $breakpoints[1000]);
        $this->assertEquals(400, $breakpoints[20000]);
    }

    public function testGetBreakpointsForValidBiannualTerm(): void
    {
        $breakpoints = $this->repository->getBreakpointsForTerm(LoanTerm::TWENTY_FOUR_MONTH);

        $this->assertArrayHasKey(1000, $breakpoints);
        $this->assertEquals(70, $breakpoints[1000]);
        $this->assertEquals(800, $breakpoints[20000]);
    }
}
