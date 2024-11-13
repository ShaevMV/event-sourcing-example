<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Order\GetOrderList;

use OrganizationalFees\Application\Model\Order\Order;
use Shared\Domain\Bus\Query\QueryResponse;

class GetOrderListQueryResponse implements QueryResponse
{
    /**
     * @param Order[] $orderList
     */
    public function __construct(
        public readonly array $orderList,
    ) {
    }
}
