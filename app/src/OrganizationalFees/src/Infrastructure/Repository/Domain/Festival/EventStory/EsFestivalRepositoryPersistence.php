<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\Festival\EventStory;

use OrganizationalFees\Domain\Festival\Model\Festival;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\Festival\Model\FestivalRepositoryPersistence;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Domain\EventSourcing\EventStore\EventStore;

class EsFestivalRepositoryPersistence implements FestivalRepositoryPersistence
{
    public function __construct(
        private readonly EventStore $eventStore,
        private readonly Projector $projector,
    ) {
    }

    public function ofId(FestivalId $aggregateId): Festival
    {
        $events = $this->eventStore->getEventStream($aggregateId);

        return Festival::reconstruct($events);
    }

    public function persist(Festival $festival): void
    {
        $events = $festival->pullEvents();
        $this->eventStore->append($events);
        $this->projector->project($events);
    }
}