# Loan Fee Calculator

A PHP 8.4 binary that calculates loan fees based on the requested loan amount and loan term duration.

## Features
- Calculate loan fees for supported loan terms.
- Configurable fee rounding and validation rules.
- Handles input parsing and validation.
- Uses moneyphp/money for accurate monetary calculations.
- Built with domain design concepts.
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
php bin/calculate-fee 11500 24

# Outputs:
460.00
```

## Project Structure
```php
src/
├── Application/                     # Application layer
│   ├── Config/                      # Configuration interface
│   ├── Parser/                      # Parsers for input (e.g., LoanApplicationRequestParser)
│   ├── Request/                     # DTOs for input validation and transfer
│   ├── Service/                     # Application services (e.g., LoanFeeCalculatorService)
│   └── Validator/                   # Validators for input (e.g., LoanApplicationRequestValidator)
├── Domain/                          # Domain models
│   └── Loan/                        # Loan-related domain objects  
│       └── Repository/              # Repository interfaces
├── Exception/                       # Custom exceptions
├── Infrastructure/                  # Infrastructure layer
│   ├── Config/                      # Configuration implementation
│   └── Repository/                  # Repository implementations
├── Util/                            # Helpers / Converters
tests/                               # Test suite
├── Unit/                            # Unit tests
bin/                                 # Binary entry point
└── calculate-fee                    # CLI entry point
```

## Key Components
- `Config` - Application configuration interface and implementation.
- `LoanApplicationRequest` - DTO for validated input data.
- `LoanApplicationRequestParser` - Parses and sanitizes raw input into a DTO.
- `LoanApplicationRequestValidator` - Validates the parsed DTO against business rules.
- `LoanApplication` – Domain model representing a loan request.
- `LoanTerm` – Enum representing available terms (e.g., TWELVE_MONTH, TWENTY_FOUR_MONTH).
- `LoanTermBreakpoints` – Domain model for loan term fee breakpoints.
- `LoanTermRepositoryInterface` – Repository abstraction for retrieving loan breakpoints.
- `LoanTermDummyRepository` – In-memory implementation of LoanTermRepositoryInterface
- `LoanTermDummyRepositoryBreakpoints` - Hardcoded fee breakpoints used by LoanTermDummyRepository.
- `LoanFeeCalculatorService` – Core service that calculates and rounds loan fees.
- `LoanFeeInterpolatorService` – Handles linear interpolation between fee breakpoints.
- `MoneyConverter` – Utility for converting between string/float and Money objects.
- `NumericSanitizer` / `MoneyConverter` – Utility classes for parsing and formatting values.

## Test And Quality Tooling Results
Results on submission from running tests, static analysis, and code style checks:

```bash
vendor/bin/phpunit
PHPUnit 12.3.8 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.12
Configuration: /Users/adamchildren/Documents/GitHub/Lendable-assessment/phpunit.xml

..........................................................        58 / 58 (100%)

Time: 00:00.200, Memory: 16.00 MB

OK (58 tests, 75 assertions)
```

```bash
vendor/bin/phpstan analyse -l 6 src
 26/26 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%
                                                                                                            
 [OK] No errors      
```

```bash
vendor/bin/phpstan analyse -l 6 tests
 13/13 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%
                                                                                                              
 [OK] No error
```

```bash
vendor/bin/php-cs-fixer fix src

PHP CS Fixer 3.87.1 Alexander by Fabien Potencier, Dariusz Ruminski and contributors.
PHP runtime: 8.4.12
Running analysis on 1 core sequentially.
You can enable parallel runner and speed up the analysis! Please see usage docs for more information.
Loaded config default.
Using cache file ".php-cs-fixer.cache".
 26/26 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

Fixed 0 of 26 files in 0.011 seconds, 16.00 MB memory used
```

```bash
vendor/bin/php-cs-fixer fix tests

PHP CS Fixer 3.87.1 Alexander by Fabien Potencier, Dariusz Ruminski and contributors.
PHP runtime: 8.4.12
Running analysis on 1 core sequentially.
You can enable parallel runner and speed up the analysis! Please see usage docs for more information.
Loaded config default.
Using cache file ".php-cs-fixer.cache".
 13/13 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%


Fixed 0 of 13 files in 0.002 seconds, 16.00 MB memory used
```