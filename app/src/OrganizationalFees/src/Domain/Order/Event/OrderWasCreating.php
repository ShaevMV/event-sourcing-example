<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Event;

use Shared\Domain\Bus\Event\Event;
use JMS\Serializer\Annotation\Type as Type;

class OrderWasCreating extends Event
{
    /**
     * @Type("array<int,string>")
     */
    public array $guestNames = [];

    public function __construct(
        string                  $aggregateId,
        array                   $guestNames,
        public readonly string  $userId,
        public readonly string  $arrangementFeeId,
        public readonly int     $price,
        public readonly int     $total,
        public readonly int     $discount = 0,
        public readonly ?string $promoCode = null,
    )
    {
        parent::__construct($aggregateId);
        $this->guestNames = $guestNames;
    }


    public static function eventName(): string
    {
        return 'arrangementFee.domain.order.creating';
    }
}