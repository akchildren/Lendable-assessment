<?php

namespace Lendable\Interview\Enum\Loan\Term;

enum LoanTerm: int
{
    // TODO: Change wording of these cases as it's not extensive to have "monthly" and "annual" only
    case ANNUAL = 12;
    case BIANNUAL = 24;
}
