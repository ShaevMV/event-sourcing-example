<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Event;

use Shared\Domain\Bus\Event\Event;

class PromoCodeWasApply extends Event
{
    public static function eventName(): string
    {
        return 'arrangementFee.domain.promoCode.apply';
    }
}
