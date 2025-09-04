<?php

namespace Lendable\Interview\Service\Loan\Term\Breakpoint;

use Lendable\Interview\Enum\Loan\Term\LoanTermDuration;

interface LoanTermBreakpointService
{
    public function getBreakpointsForTerm(LoanTermDuration $term): array;
}
