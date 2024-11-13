<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeAllPriceList;

use Shared\Domain\Bus\Query\Query;

class GetArrangementFeeAllPriceListQuery implements Query
{
    public function __construct(
        public readonly string $festivalId,
    ) {
    }
}
