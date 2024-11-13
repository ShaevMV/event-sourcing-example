<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeList;

use Shared\Domain\Bus\Query\Query;

class GetArrangementFeeListQuery implements Query
{
    public function __construct(
        public readonly string $festivalId,
    ) {
    }
}
