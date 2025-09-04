<?php

namespace Lendable\Interview\Enum\Loan\Term;

enum LoanTermDuration: int
{
    case ANNUAL = 12;
    case BIANNUAL = 24;
}
