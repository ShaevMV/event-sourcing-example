<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\PromoCode\EventStory;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeRepositoryPersistence;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Domain\EventSourcing\EventStore\EventStore;

class EsPromoCodeRepositoryPersistence implements PromoCodeRepositoryPersistence
{

    public function __construct(
        private readonly EventStore $eventStore,
        private readonly Projector $projector,
    ) {
    }

    public function ofId(PromoCodeId $id): PromoCode
    {
        $events = $this->eventStore->getEventStream($id);

        return PromoCode::reconstruct($events);
    }

    public function persist(PromoCode $object): void
    {
        $events = $object->pullEvents();
        $this->eventStore->append($events);
        $this->projector->project($events);
    }
}