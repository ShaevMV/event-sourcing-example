<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\ArrangementFee;

class ArrangementFee
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $festivalId,
        public readonly int $price,
    ) {
    }
}
