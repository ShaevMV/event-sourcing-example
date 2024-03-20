<?php

namespace ArrangementFee\Application\Model;

interface OrderRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getOrderList(): array;
}