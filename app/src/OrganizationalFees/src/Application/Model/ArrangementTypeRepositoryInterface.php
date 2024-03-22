<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementTypeId;

interface ArrangementTypeRepositoryInterface
{
    public function getArrangementType(ArrangementTypeId $arrangementTypeId): ArrangementType;
}