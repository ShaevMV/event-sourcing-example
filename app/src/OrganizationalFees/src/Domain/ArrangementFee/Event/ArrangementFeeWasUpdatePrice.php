<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Event;

use Shared\Domain\Bus\Event\Event;

class ArrangementFeeWasUpdatePrice extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly int $price,
        public readonly int $timestamp,
    ) {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'organizationalFees.domain.arrangementFee.updatePrice';
    }
}
