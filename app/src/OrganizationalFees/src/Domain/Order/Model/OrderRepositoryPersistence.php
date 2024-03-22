<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Shared\Domain\Aggregate\AggregateId;

interface OrderRepositoryPersistence
{
    public function ofId(AggregateId $orderId): Order;

    public function persist(Order $order): void;
}