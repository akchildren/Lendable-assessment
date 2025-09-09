# Loan Fee Calculator

A PHP 8.4 application that calculates loan fees based on requested loan amount and loan term duration.
The project demonstrates domain-driven design principles, data transfer objects, repositories, and services for interpolation and rounding of loan fees.

## Requirements
- PHP 8.4+
- Composer
- moneyphp/money for monetary calculations
- vlucas/phpdotenv for environment configuration
- PHPUnit for tests
- PhpStan for static analysis (Level 6)
- PHP-CS-Fixer for code style

## Installation
```
git clone <repository-url>
cd loan-fee-calculator
composer install
cp .env.example .env # create .env from example (optional as default values are set)
```
## Configuration

The application is configured via .env. Example:
```
MIN_LOAN_AMOUNT=1000
MAX_LOAN_AMOUNT=20000
FEE_ROUNDING_INTERVAL=5
```

## Usage
Run the binary to calculate loan fees:
```bash
php bin/calculate-fee <amount> <term>
```

#### Example:
```bash
calculate-fee 11,500.00 24
```

#### Output:
```bash
460.00
```

## Project Structure
```php
src/
├── Application/          # Application layer
│   ├── Request/            # DTOs for input validation and transfer
│   └── Service/            # Application services (e.g., LoanFeeCalculatorService)
├── Domain/               # Domain models (e.g., LoanApplication, LoanTerm)
│   └── Loan/             
├── Enum/                 # Enums (e.g., LoanTerm)
├── Exception/            # Custom exceptions
├── Infrastructure /      # Infrastructure layer
│   └──  Repository         # Repository interfaces and implementations
├── Util/                 # Helpers / Converters
tests/
├── Unit/                 # Unit tests
bin/
└── calculate-fee         # CLI entry point
```

## Key Components

- LoanApplication – Domain model representing a loan request.
- LoanApplicationRequestDto – DTO used to pass validated input into the calculator.
- LoanTerm – Enum representing available terms (e.g., TWELVE_MONTH, TWENTY_FOUR_MONTH).
- LoanFeeCalculatorService – Core service that calculates and rounds loan fees.
- LoanTermRepositoryInterface – Repository abstraction for retrieving loan breakpoints.
- LoanFeeInterpolatorService – Handles linear interpolation between fee breakpoints.
- NumericSanitizer / MoneyConverter – Utility classes for parsing and formatting values.

## Running Tests

All tests are written with PHPUnit.
```bash
vendor/bin/phpunit
```

## Development Notes
- All PHP files use declare(strict_types=1); for strict typing.
- DTOs are immutable (readonly) to ensure safe data transfer.
- Repositories can be swapped (dummy, in-memory, database-backed) without changing the service layer.
- Fee rounding interval is configurable via .env.