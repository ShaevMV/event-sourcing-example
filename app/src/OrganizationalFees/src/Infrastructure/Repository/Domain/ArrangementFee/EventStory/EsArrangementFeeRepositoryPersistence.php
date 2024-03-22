<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Domain\EventSourcing\EventStore\EventStore;

class EsArrangementFeeRepositoryPersistence implements ArrangementFeeRepositoryPersistence
{

    public function __construct(
        private readonly EventStore $eventStore,
        private readonly Projector $projector,
    ) {
    }

    public function ofId(ArrangementId $aggregateId): ArrangementFee
    {
        $events = $this->eventStore->getEventStream($aggregateId);

        return ArrangementFee::reconstruct($events);
    }

    public function persist(ArrangementFee $arrangementFee): void
    {
        $events = $arrangementFee->pullEvents();
        $this->eventStore->append($events);
        $this->projector->project($events);
    }
}