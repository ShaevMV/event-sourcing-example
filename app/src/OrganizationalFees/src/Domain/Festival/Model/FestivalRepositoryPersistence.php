<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Model\Order;
use Shared\Domain\Aggregate\AggregateId;

interface FestivalRepositoryPersistence
{
    public function ofId(FestivalId $aggregateId): Festival;

    public function persist(Festival $festival): void;
}