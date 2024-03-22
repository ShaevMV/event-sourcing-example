<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use OrganizationalFees\Domain\Order\Model\Order;
use Shared\Domain\Aggregate\AggregateId;

interface ArrangementFeeRepositoryPersistence
{
    public function ofId(ArrangementId $aggregateId): ArrangementFee;

    public function persist(ArrangementFee $arrangementFee): void;
}