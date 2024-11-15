<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PaymentMethod\Model;

interface PaymentMethodPersistence
{
    public function ofId(PaymentMethodId $aggregateId): PaymentMethod;

    public function persist(PaymentMethod $typesOfPayment): void;
}
