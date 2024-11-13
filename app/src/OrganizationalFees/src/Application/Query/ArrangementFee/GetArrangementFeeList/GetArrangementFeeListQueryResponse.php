<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeList;

use OrganizationalFees\Application\Model\ArrangementFee\ArrangementFee;
use Shared\Domain\Bus\Query\QueryResponse;

class GetArrangementFeeListQueryResponse implements QueryResponse
{
    /**
     * @param ArrangementFee[] $arrangementFees
     */
    public function __construct(
        public readonly array $arrangementFees,
    ) {
    }
}
