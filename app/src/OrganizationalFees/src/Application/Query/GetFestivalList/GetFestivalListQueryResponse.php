<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\GetFestivalList;

use OrganizationalFees\Application\Model\Festival\Festival;
use Shared\Domain\Bus\Query\QueryResponse;

class GetFestivalListQueryResponse implements QueryResponse
{
    /**
     * @param Festival[] $festivalList
     */
    public function __construct(
        public readonly array $festivalList,
    ) {
    }
}
