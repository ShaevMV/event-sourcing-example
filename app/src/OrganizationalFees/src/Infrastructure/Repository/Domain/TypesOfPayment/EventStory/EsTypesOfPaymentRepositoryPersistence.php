<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\TypesOfPayment\EventStory;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\TypesOfPayment\Model\TypesOfPayment;
use OrganizationalFees\Domain\TypesOfPayment\Model\TypesOfPaymentPersistence;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Domain\EventSourcing\EventStore\EventStore;

class EsTypesOfPaymentRepositoryPersistence implements TypesOfPaymentPersistence
{
    public function __construct(
        private readonly EventStore $eventStore,
        private readonly Projector $projector,
    ) {
    }

    public function ofId(ArrangementId $aggregateId): TypesOfPayment
    {
        $events = $this->eventStore->getEventStream($aggregateId);

        return TypesOfPayment::reconstruct($events);
    }

    public function persist(TypesOfPayment $typesOfPayment): void
    {
        $events = $typesOfPayment->pullEvents();
        $this->eventStore->append($events);
        $this->projector->project($events);
    }
}
