<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Query\GetOrderList;

use ArrangementFee\Application\Model\Order;
use Shared\Domain\Bus\Query\QueryResponse;

class GetOrderListQueryResponse implements QueryResponse
{
    /**
     * @param Order[] $orderList
     */
    public function __construct(
        public readonly array $orderList
    )
    {
    }
}