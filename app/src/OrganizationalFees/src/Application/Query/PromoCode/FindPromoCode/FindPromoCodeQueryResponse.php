<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\PromoCode\FindPromoCode;

use Shared\Domain\Bus\Query\QueryResponse;

class FindPromoCodeQueryResponse implements QueryResponse
{
    public function __construct(
        public readonly string $id,
        public readonly int $discount,
    ) {
    }
}
