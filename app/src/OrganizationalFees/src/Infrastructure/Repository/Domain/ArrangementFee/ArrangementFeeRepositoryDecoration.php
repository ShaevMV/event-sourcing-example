<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;

class ArrangementFeeRepositoryDecoration
{
    public function __construct(
        public readonly ArrangementFeeRepositoryPersistence $arrangementFeeRepositoryPersistence
    ) {
    }

    public function ofId(ArrangementId $aggregateId): ArrangementFee
    {
        return $this->arrangementFeeRepositoryPersistence->ofId($aggregateId);
    }

    public function persist(ArrangementFee $arrangementFee): void
    {
        $this->arrangementFeeRepositoryPersistence->persist($arrangementFee);
    }
}
