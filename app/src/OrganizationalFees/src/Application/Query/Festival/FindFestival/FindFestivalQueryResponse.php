<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Festival\FindFestival;

use OrganizationalFees\Application\Model\Festival\Festival;

class FindFestivalQueryResponse
{
    public function __construct(
        public readonly ?Festival $festival = null,
    ) {
    }
}
