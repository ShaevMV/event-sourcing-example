<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Model;

use ArrangementFee\Domain\ArrangementFee\Model\ArrangementTypeId;

interface ArrangementTypeRepositoryInterface
{
    public function getArrangementType(ArrangementTypeId $arrangementTypeId): ArrangementType;
}