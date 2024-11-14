<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\TypesOfPayment\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;

interface TypesOfPaymentPersistence
{
    public function ofId(ArrangementId $aggregateId): TypesOfPayment;

    public function persist(TypesOfPayment $typesOfPayment): void;
}
