<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PaymentMethod\Event;

use Shared\Domain\Bus\Event\Event;

class PaymentMethodWasCreating extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly string $accountDetails,
        public readonly bool $active,
        public readonly int $order,
        public readonly string $festivalId,
    ) {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'organizationalFees.domain.typesOfPayment.creating';
    }
}
