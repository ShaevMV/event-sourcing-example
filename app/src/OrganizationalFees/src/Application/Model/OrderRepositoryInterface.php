<?php

namespace OrganizationalFees\Application\Model;

interface OrderRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getOrderList(): array;
}
