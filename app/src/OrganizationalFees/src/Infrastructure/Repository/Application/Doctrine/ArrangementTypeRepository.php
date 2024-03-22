<?php

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use OrganizationalFees\Application\Model\ArrangementType;
use OrganizationalFees\Application\Model\ArrangementTypeRepositoryInterface;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementTypeId;

class ArrangementTypeRepository implements ArrangementTypeRepositoryInterface
{
    public function getArrangementType(ArrangementTypeId $arrangementTypeId): ArrangementType
    {
        // TODO: Implement getArrangementType() method.
    }
}