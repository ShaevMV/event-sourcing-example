<?php

declare(strict_types=1);

namespace ArrangementFee\Domain\Order\Event;

use Shared\Domain\Bus\Event\Event;
use JMS\Serializer\Annotation\Type as Type;

class OrderWasCreating extends Event
{
    /**
     * @Type("array<int,string>")
     */
    public array $guestNames = [];

    public function __construct(
        string                 $aggregateId,
        array                  $guestNames,
        public readonly string $userId,
        public readonly string $ticketTypeId,
        public readonly string $promoCode
    )
    {
        parent::__construct($aggregateId);
        $this->guestNames = $guestNames;
    }


    public static function eventName(): string
    {
        return 'ArrangementFee.domain.order.creating';
    }
}