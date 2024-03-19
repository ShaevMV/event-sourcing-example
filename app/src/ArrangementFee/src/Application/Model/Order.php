<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Model;

class Order
{
    public readonly array $guest;

    public function __construct(
        public readonly string $id,
        array $guest,
        public readonly string $typeArrangementId,
        public readonly string $userId,
        public readonly string $status,
    )
    {
        $this->guest = $guest;
    }
}