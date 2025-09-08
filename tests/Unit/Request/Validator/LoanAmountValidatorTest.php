<?php
declare(strict_types=1);

namespace Lendable\Interview\Unit\Request\Validator;

use Lendable\Interview\Exception\Validator\ValidationException;
use Lendable\Interview\Request\Loan\Validator\LoanAmountValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LoanAmountValidatorTest extends TestCase
{
    #[DataProvider('validAmounts')]
    public function testValidAmounts(?string $input): void
    {
        $validator = new LoanAmountValidator($input);
        $this->expectNotToPerformAssertions(); // validate should not throw
        $validator->validate();
    }

    #[DataProvider('invalidAmounts')]
    public function testInvalidAmounts(?string $input): void
    {
        $this->expectException(ValidationException::class);
        $validator = new LoanAmountValidator($input);
        $validator->validate();
    }

    /**
     * @return array<int, list<string>>
     */
    public static function validAmounts(): array
    {
        return [
            ['1000'],
            ['20000'],
            ['1500.50'],
            ['12,345.67'],
        ];
    }

    /**
     * @return array<int, list<string|null>>
     */
    public static function invalidAmounts(): array
    {
        return [
            [null],       // required
            ['999'],      // below min
            ['20001'],    // above max
            ['abc'],      // non-numeric
        ];
    }
}
