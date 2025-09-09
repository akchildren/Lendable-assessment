# Loan Fee Calculator

A PHP 8.4 binary that calculates loan fees based on the requested loan amount and loan term duration.

## Features
- Calculate loan fees for supported loan terms.
- Configurable fee rounding and validation rules.
- Built with domain design concepts (Domain models, DTOs, Services, Repositories).
- Fully covered by automated unit tests and static analysis tools.

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
## Configuration (Optional)

The application can be configured via an `.env` file :
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
│   │   │── Parser/             # Parsers for input (e.g., LoanApplicationRequestParser)
│   │   └── Validator/          # Validators for input (e.g., LoanApplicationRequestValidator)
│   └── Service/            # Application services (e.g., LoanFeeCalculatorService)
├── Domain/               # Domain models (e.g., LoanApplication, LoanTerm)
│   └── Loan/               # Loan related domain objects  
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
- LoanApplicationRequest - DTO for validated input data.
- LoanApplication – Domain model representing a loan request.
- LoanTerm – Enum representing available terms (e.g., TWELVE_MONTH, TWENTY_FOUR_MONTH).
- LoanTermBreakpoints – Domain model for loan term fee breakpoints.
- LoanTermRepositoryInterface – Repository abstraction for retrieving loan breakpoints.
- LoanTermDummyRepository – In-memory implementation of LoanTermRepositoryInterface (using hardcoded data from readme).
- LoanFeeCalculatorService – Core service that calculates and rounds loan fees.
- LoanFeeInterpolatorService – Handles linear interpolation between fee breakpoints.
- MoneyConverter – Utility for converting between string/float and Money objects.
- NumericSanitizer / MoneyConverter – Utility classes for parsing and formatting values.

## Test And Quality Tooling Results
Results on submission from running tests, static analysis, and code style checks:

```bash
vendor/bin/phpunit
PHPUnit 12.3.8 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.12
Configuration: /Users/adamchildren/Documents/GitHub/Lendable-assessment/phpunit.xml

....................................................              52 / 52 (100%)

Time: 00:00.200, Memory: 16.00 MB

OK (52 tests, 63 assertions)
```

```bash
vendor/bin/phpstan analyse -l 6 src
 24/24 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%
                                                                                                 
 [OK] No errors  
```

```bash
vendor/bin/phpstan analyse -l 6 tests
 24/24 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%
                                                                                                 
 [OK] No errors  
```

```bash
vendor/bin/php-cs-fixer fix src

PHP CS Fixer 3.87.1 Alexander by Fabien Potencier, Dariusz Ruminski and contributors.
PHP runtime: 8.4.12
Running analysis on 1 core sequentially.
You can enable parallel runner and speed up the analysis! Please see usage docs for more information.
Loaded config default.
Using cache file ".php-cs-fixer.cache".
 24/24 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%


Fixed 0 of 24 files in 0.003 seconds, 16.00 MB memory used
```

```bash
vendor/bin/php-cs-fixer fix tests

PHP CS Fixer 3.87.1 Alexander by Fabien Potencier, Dariusz Ruminski and contributors.
PHP runtime: 8.4.12
Running analysis on 1 core sequentially.
You can enable parallel runner and speed up the analysis! Please see usage docs for more information.
Loaded config default.
Using cache file ".php-cs-fixer.cache".
 11/11 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%


Fixed 0 of 11 files in 0.002 seconds, 16.00 MB memory used
```