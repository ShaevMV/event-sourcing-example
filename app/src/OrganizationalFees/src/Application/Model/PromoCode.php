<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model;

class PromoCode
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly int    $discount,
        public readonly string $festivalId,
        public readonly string $sing,
        public readonly ?int   $limit = null,
    )
    {
    }
}