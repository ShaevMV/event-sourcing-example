<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Order\GetOrderList;

use Shared\Domain\Bus\Query\Query;

class GetOrderListQuery implements Query
{
    public function __construct(
        public readonly string $festivalId,
        public readonly ?string $email,
        public readonly ?string $status,
        public readonly ?int $price,
        public readonly ?string $promoCode,
    ) {
    }
}
