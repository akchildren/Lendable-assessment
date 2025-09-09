<?php

declare(strict_types=1);

namespace Lendable\Interview\Infrastructure\Repository\Loan\Term;

use Lendable\Interview\Domain\Loan\LoanTerm;
use Lendable\Interview\Enum\Loan\Term\LoanTermDummyBreakpoints;

/**
 * Dummy repository for loan terms.
 *
 * This repository uses predefined data from LoanTermBreakpoints.
 * @note This is a dummy implementation and should be replaced with a real data source.
 */
final class LoanTermDummyRepository extends AbstractLoanTermRepository
{
    /**
     * @param LoanTerm $term
     * @return array<int, int>
     */
    protected function fetchBreakpoints(LoanTerm $term): array
    {
        return LoanTermDummyBreakpoints::DATA[$term->value];
    }
}
