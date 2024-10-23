<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

interface ArrangementFeeRepositoryPersistence
{
    public function ofId(ArrangementId $aggregateId): ArrangementFee;

    public function persist(ArrangementFee $arrangementFee): void;
}
