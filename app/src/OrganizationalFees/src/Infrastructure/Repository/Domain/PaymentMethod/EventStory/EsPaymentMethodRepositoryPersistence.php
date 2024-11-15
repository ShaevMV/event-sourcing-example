<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\PaymentMethod\EventStory;

use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethod;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodPersistence;
use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Domain\EventSourcing\EventStore\EventStore;

class EsPaymentMethodRepositoryPersistence implements PaymentMethodPersistence
{
    public function __construct(
        private readonly EventStore $eventStore,
        private readonly Projector $projector,
    ) {
    }

    public function ofId(AggregateId $aggregateId): PaymentMethod
    {
        $events = $this->eventStore->getEventStream($aggregateId);

        return PaymentMethod::reconstruct($events);
    }

    public function persist(PaymentMethod $typesOfPayment): void
    {
        $events = $typesOfPayment->pullEvents();
        $this->eventStore->append($events);
        $this->projector->project($events);
    }
}
