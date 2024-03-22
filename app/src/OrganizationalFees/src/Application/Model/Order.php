<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model;

class Order
{
    public readonly array $guest;

    public function __construct(
        public readonly string $id,
        array $guest,
        public readonly string $typeArrangementId,
        public readonly string $userId,
        public readonly string $status,
        public readonly int $price,
        public readonly string $promoCode = '',
        public readonly int $discount = 0,
    )
    {
        $this->guest = $guest;
    }
}