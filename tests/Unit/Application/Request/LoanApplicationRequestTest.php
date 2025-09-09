<?php

declare(strict_types=1);

namespace Lendable\Interview\Unit\Application\Request;

use Lendable\Interview\Application\Request\Loan\LoanApplicationRequest;
use Lendable\Interview\Domain\Loan\LoanTerm;
use Lendable\Interview\Exception\Validator\ValidationException;
use Money\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LoanApplicationRequestTest extends TestCase
{
    #[DataProvider('validInputs')]
    public function testValidRequest(string $amount, int $term): void
    {
        $request = new LoanApplicationRequest($amount, $term);
        $data = $request->validate()->safe();

        $this->assertInstanceOf(Money::class, $data['amount']);
        $this->assertInstanceOf(LoanTerm::class, $data['term']);
    }

    #[DataProvider('invalidInputs')]
    public function testInvalidRequest(?string $amount, mixed $term): void
    {
        $this->expectException(ValidationException::class);
        $request = new LoanApplicationRequest($amount, $term);
        $request->validate();
    }

    /**
     * @return array<int, list<int|string>>
     */
    public static function validInputs(): array
    {
        return [
            ['1000', 12],
            ['15000.50', 24],
            ['12,345.67', 12],
        ];
    }

    /**
     * @return array<int, list<int|string|null>>
     */
    public static function invalidInputs(): array
    {
        return [
            [null, 12],          // amount missing
            ['1000', null],      // term missing
            ['999', 12],         // amount too low
            ['20001', 24],       // amount too high
            ['1500', 36],        // invalid term
            ['abc', 12],         // non-numeric amount
        ];
    }
}
