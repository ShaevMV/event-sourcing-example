<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\FindActiveFestival;

use OrganizationalFees\Application\Model\Festival\Festival;
use Shared\Domain\Bus\Query\QueryResponse;

class FindActiveFestivalQueryResponse implements QueryResponse
{
    public function __construct(
        public readonly ?Festival $festival = null,
    )
    {
    }
}