<?php

declare(strict_types=1);

namespace Lendable\Interview\Unit\Application\Service\Loan\Fee;

use Lendable\Interview\Application\Service\Loan\Fee\LoanFeeCalculatorService;
use Lendable\Interview\Application\Service\Loan\Fee\LoanFeeInterpolatorService;
use Lendable\Interview\Domain\Loan\LoanApplication;
use Lendable\Interview\Domain\Loan\LoanTerm;
use Lendable\Interview\Infrastructure\Repository\Loan\Term\LoanTermDummyRepository;
use Lendable\Interview\Util\MoneyConverter;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class LoanFeeCalculatorServiceTest extends TestCase
{
    private LoanFeeCalculatorService $calculator;

    protected function setUp(): void
    {
        $this->calculator = new LoanFeeCalculatorService(
            loanTermRepository: new LoanTermDummyRepository(),
            interpolator: new LoanFeeInterpolatorService(),
            roundingInterval: 5
        );
    }

    public function testCalculatesAndRoundsFeeCorrectly(): void
    {
        $loanRequestData = new LoanApplication(
            amount: MoneyConverter::parseFloat(11500.00),
            term: LoanTerm::TWENTY_FOUR_MONTH,
        );

        $result = $this->calculator->calculate($loanRequestData);

        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals('46000', $result->getAmount());
    }
}
