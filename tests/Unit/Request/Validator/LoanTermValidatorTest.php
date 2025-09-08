<?php
declare(strict_types=1);

namespace Lendable\Interview\Unit\Request\Validator;

use Lendable\Interview\Request\Loan\Validator\LoanTermValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LoanTermValidatorTest extends TestCase
{
    #[DataProvider('validTerms')]
    public function testValidTerms(mixed $term): void
    {
        $validator = new LoanTermValidator($term);
        $this->expectNotToPerformAssertions();
        $validator->validate();
    }

    #[DataProvider('invalidTerms')]
    public function testInvalidTerms(mixed $term): void
    {
        $this->expectException(\Throwable::class);
        $validator = new LoanTermValidator($term);
        $validator->validate();
    }

    /**
     * @return array<int, list<int>>
     */
    public static function validTerms(): array
    {
        return [
            [12],
            [24],
        ];
    }

    /**
     * @return array<int, list<mixed>>
     */
    public static function invalidTerms(): array
    {
        return [
            [null],
            [36],        // not a preset term
            ['abc'],     // strict type
        ];
    }
}
