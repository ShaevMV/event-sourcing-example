<?php

declare(strict_types=1);

namespace ArrangementFee\Infrastructure\Repository\Domain\Order;

use ArrangementFee\Domain\Order\Model\Order;
use ArrangementFee\Domain\Order\Model\OrderRepositoryPersistence;
use Shared\Domain\Aggregate\AggregateId;

class OrderRepositoryDecoration
{
    public function __construct(
        private readonly OrderRepositoryPersistence $orderRepositoryPersistence
    )
    {
    }

    public function ofId(AggregateId $orderId): Order
    {
        return $this->orderRepositoryPersistence->ofId($orderId);
    }

    public function persist(Order $order): void
    {
        $this->orderRepositoryPersistence->persist($order);
    }
}