<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Festival\GetFestival;

use OrganizationalFees\Application\Model\Festival\Festival;

class GetFestivalQueryResponse
{
    public function __construct(
        public readonly ?Festival $festival = null,
    ) {
    }
}
