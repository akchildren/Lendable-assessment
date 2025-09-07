<?php

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
        $breakpoints = $this->repository->getBreakpointsForTerm(LoanTerm::ANNUAL);

        $this->assertIsArray($breakpoints);
        $this->assertArrayHasKey(1000, $breakpoints);
        $this->assertEquals(50, $breakpoints[1000]);
        $this->assertEquals(400, $breakpoints[20000]);
    }

    public function testGetBreakpointsForValidBiannualTerm(): void
    {
        $breakpoints = $this->repository->getBreakpointsForTerm(LoanTerm::BIANNUAL);

        $this->assertIsArray($breakpoints);
        $this->assertArrayHasKey(1000, $breakpoints);
        $this->assertEquals(70, $breakpoints[1000]);
        $this->assertEquals(800, $breakpoints[20000]);
    }

    public function testBreakpointsStructure(): void
    {
        foreach ([LoanTerm::ANNUAL, LoanTerm::BIANNUAL] as $term) {
            $breakpoints = $this->repository->getBreakpointsForTerm($term);

            foreach ($breakpoints as $amount => $fee) {
                $this->assertIsInt($amount);
                $this->assertIsInt($fee);
            }
        }
    }
}
