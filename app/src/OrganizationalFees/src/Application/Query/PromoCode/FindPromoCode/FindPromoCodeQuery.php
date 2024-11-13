<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\PromoCode\FindPromoCode;

use Shared\Domain\Bus\Query\Query;

class FindPromoCodeQuery implements Query
{
    public function __construct(
        public readonly string $title,
        public readonly string $festivalId,
    ) {
    }
}
