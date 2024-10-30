<?php

namespace OrganizationalFees\Application\Model\Order;

use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQuery;

interface OrderRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getOrderList(GetOrderListQuery $query): array;
}