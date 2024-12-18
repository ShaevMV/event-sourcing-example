<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\Order\EventStore;

use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Domain\EventSourcing\EventStore\EventStore;

class EsOrderRepositoryPersistence implements OrderRepositoryPersistence
{
    public function __construct(
        private readonly EventStore $eventStore,
        private readonly Projector $projector,
    ) {
    }

    public function ofId(AggregateId $orderId): Order
    {
        $events = $this->eventStore->getEventStream($orderId);

        return Order::reconstruct($events);
    }

    public function persist(Order $order): void
    {
        $events = $order->pullEvents();
        $this->eventStore->append($events);
        $this->projector->project($events);
    }
}
