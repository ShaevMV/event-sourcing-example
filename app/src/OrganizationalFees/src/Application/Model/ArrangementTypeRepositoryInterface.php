<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;

interface ArrangementTypeRepositoryInterface
{
    public function getArrangementType(ArrangementId $arrangementTypeId): ArrangementType;
}