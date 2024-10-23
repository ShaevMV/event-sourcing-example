<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\Order;

use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use Shared\Domain\Aggregate\AggregateId;

class OrderRepositoryDecoration
{
    public function __construct(
        private readonly OrderRepositoryPersistence $orderRepositoryPersistence,
    ) {
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
