<?php

namespace Lendable\Interview\Repository\Loan\Term;

use Lendable\Interview\Enum\Loan\Term\LoanTermBreakPoints;

/**
 * Dummy repository for loan terms.
 *
 * This repository uses predefined data from LoanTermBreakpoints.
 * @note This is a dummy implementation and should be replaced with a real data source.
 */
final readonly class LoanTermDummyRepository extends AbstractLoanTermRepository
{
    public function __construct()
    {
        parent::__construct(LoanTermBreakpoints::DATA);
    }
}
