<?php

namespace ArrangementFee\Application\Model;

interface ArrangementFeeRepositoryInterface
{
    /**
     * @return Order[]
     */
    public function getOrderList(): array;
}