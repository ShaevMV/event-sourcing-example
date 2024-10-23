<?php

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use OrganizationalFees\Application\Model\ArrangementType;
use OrganizationalFees\Application\Model\ArrangementTypeRepositoryInterface;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;

class ArrangementTypeRepository implements ArrangementTypeRepositoryInterface
{
    public function getArrangementType(ArrangementId $arrangementTypeId): ArrangementType
    {
        // TODO: Implement getArrangementType() method.
    }
}
