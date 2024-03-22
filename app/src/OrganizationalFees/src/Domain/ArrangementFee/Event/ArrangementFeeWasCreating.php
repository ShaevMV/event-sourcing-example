<?php

namespace OrganizationalFees\Domain\ArrangementFee\Event;

use Shared\Domain\Bus\Event\Event;

class ArrangementFeeWasCreating extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly string $name,
        public readonly int $price,
        public readonly string $festivalId,
    )
    {
        parent::__construct($aggregateId);
    }


    public static function eventName(): string
    {
       return 'arrangementFee.domain.arrangementFee.creating';
    }
}