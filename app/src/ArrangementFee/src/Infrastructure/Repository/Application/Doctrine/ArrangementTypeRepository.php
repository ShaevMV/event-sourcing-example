<?php

namespace ArrangementFee\Infrastructure\Repository\Application\Doctrine;

use ArrangementFee\Application\Model\ArrangementType;
use ArrangementFee\Application\Model\ArrangementTypeRepositoryInterface;
use ArrangementFee\Domain\ArrangementFee\Model\ArrangementTypeId;

class ArrangementTypeRepository implements ArrangementTypeRepositoryInterface
{

    public function getArrangementType(ArrangementTypeId $arrangementTypeId): ArrangementType
    {
        // TODO: Implement getArrangementType() method.
    }
}