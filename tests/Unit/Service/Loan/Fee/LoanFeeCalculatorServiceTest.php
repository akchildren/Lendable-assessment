<?php

namespace Lendable\Interview\Unit\Service\Loan\Fee;

use Lendable\Interview\DataTransferObject\Loan\LoanApplicationRequestDto;
use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Util\MoneyConverter;
use Lendable\Interview\Repository\Loan\Term\LoanTermDummyRepository;
use Lendable\Interview\Service\Loan\Fee\LoanFeeCalculatorService;
use Lendable\Interview\Service\Loan\Fee\LoanFeeInterpolatorService;
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
        $loanRequestData = new LoanApplicationRequestDto(
            amount: MoneyConverter::parseFloat(11500.00),
            term: LoanTerm::BIANNUAL,
        );

        $result = $this->calculator->calculate($loanRequestData);

        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals('46000', $result->getAmount());
    }
}
