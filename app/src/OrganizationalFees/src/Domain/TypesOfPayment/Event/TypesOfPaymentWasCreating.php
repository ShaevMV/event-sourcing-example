<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\TypesOfPayment\Event;

use Shared\Domain\Bus\Event\Event;

class TypesOfPaymentWasCreating extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly string $name,
        public readonly bool $active,
        public readonly int $sort,
        public readonly string $festivalId,
    ) {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'organizationalFees.domain.typesOfPayment.creating';
    }
}
