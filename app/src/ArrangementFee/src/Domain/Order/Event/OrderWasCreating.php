<?php

declare(strict_types=1);

namespace ArrangementFee\Domain\Order\Event;

use Shared\Domain\Bus\Event\Event;

class OrderWasCreating extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly array $guestNames,
        public readonly string $userId,
        public readonly string $ticketTypeId,
        public readonly string $promoCode
    )
    {
        parent::__construct($aggregateId);
    }


    public static function eventName(): string
    {
        return 'order.domain.order.creating';
    }
}