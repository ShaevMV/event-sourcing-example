<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Event;

use Shared\Domain\Bus\Event\Event;

class PromoCodeWasCreating extends Event
{
    public function __construct(
        string                 $aggregateId,
        public readonly string $title,
        public readonly int    $discount,
        public readonly string $festivalId,
        public readonly string $promoCodeSing,
        public readonly ?int   $limit,
    )
    {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'arrangementFee.domain.promoCode.creating';
    }
}