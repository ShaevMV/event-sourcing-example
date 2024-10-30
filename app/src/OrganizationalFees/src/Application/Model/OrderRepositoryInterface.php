<?php

namespace OrganizationalFees\Application\Model;

use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQuery;

interface OrderRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getOrderList(GetOrderListQuery $query): array;
}
