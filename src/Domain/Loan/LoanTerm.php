<?php

declare(strict_types=1);

namespace Lendable\Interview\Domain\Loan;

enum LoanTerm: int
{
    case TWELVE_MONTH = 12;
    case TWENTY_FOUR_MONTH = 24;
}
