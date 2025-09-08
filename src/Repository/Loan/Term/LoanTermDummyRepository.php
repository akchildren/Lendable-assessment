<?php

namespace Lendable\Interview\Repository\Loan\Term;

use Lendable\Interview\Enum\Loan\Term\LoanTerm;
use Lendable\Interview\Enum\Loan\Term\LoanTermBreakPoints;

/**
 * Dummy repository for loan terms.
 *
 * This repository uses predefined data from LoanTermBreakpoints.
 * @note This is a dummy implementation and should be replaced with a real data source.
 */
final class LoanTermDummyRepository extends AbstractLoanTermRepository
{
    protected function fetchBreakpoints(LoanTerm $term): array
    {
        return LoanTermBreakpoints::DATA[$term->value];
    }
}
