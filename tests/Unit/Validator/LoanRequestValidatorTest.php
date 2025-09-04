<?php

namespace Lendable\Interview\Unit\Validator;

use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;
use Lendable\Interview\Helper\MoneyHelper;
use Lendable\Interview\Helper\StringHelper;
use Lendable\Interview\Validator\Loan\LoanRequestValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LoanRequestValidatorTest extends TestCase
{
    private LoanRequestValidator $validator;

    public function test_loan_request_validator_valid_safe_data_success(): void
    {
        $amount = '10,000.00';
        $term = LoanTermDuration::ANNUAL;

        $this->validator = new LoanRequestValidator(
            amount: $amount,
            term: $term->value
        );

        $this->assertEquals(
            [
                'amount' => MoneyHelper::parseFloat(StringHelper::sanitiseFloatString($amount)),
                'term' => $term
            ],
            $this->validator->validate()->safe()
        );
    }

    #[DataProvider('invalidAmountDataProvider')]
    public function test_loan_request_validator_amount_invalid_data_scenarios(
        mixed $amount,
        string $exceptionMessage
    ): void
    {
        $this->markTestIncomplete('Requires data provider implementation');
        $this->validator = new LoanRequestValidator(
            amount: $amount,
            term: LoanTermDuration::ANNUAL->value
        );
    }

    public static function invalidAmountDataProvider(): array
    {
        return [
            'amount is null' => [
                'amount' => null,
                'exceptionMessage' => 'Amount is required'
            ],
            'amount is empty string' => [
                'amount' => '',
                'exceptionMessage' => 'Amount is required'
            ],
            'amount is not a float' => [
                'amount' => 'test',
                'exceptionMessage' => 'Amount must be numeric'
            ],
            'amount is less than minimum' => [
                'amount' => '0',
                'exceptionMessage' => 'Amount must be between 1000 and 20000. 999.99 was given'
            ],
            'amount is greater than maximum' => [
                'amount' => '100,000.01',
                'exceptionMessage' => 'Amount must be between 1000 and 20000. 20000.01 was given'
            ],
        ];
    }

    #[DataProvider('invalidTermDataProvider')]
    public function test_loan_request_validator_term_invalid_data_scenarios(
        mixed $term,
        string $exceptionMessage
    ): void
    {
        $this->markTestIncomplete('Requires data provider implementation');
        $this->validator = new LoanRequestValidator(
            amount: '10,000.00',
            term: $term
        );
    }

    public static function invalidTermDataProvider(): array
    {
        return [
            'term is null' => [
                'term' => null,
                'exceptionMessage' => 'Term is required'
            ],
            'term is empty string' => [
                'term' => '',
                'exceptionMessage' => 'Term is required'
            ],
            'term is not an unsigned integer' => [
                'term' => 'test',
                'exceptionMessage' => 'Term must be one of: annual, biannual'
            ],
            'term is invalid term enumeration' => [
                'term' => '18',
                'exceptionMessage' => 'Term must be one of: annual, biannual'
            ],
        ];
    }
}