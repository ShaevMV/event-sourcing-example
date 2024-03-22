<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model;

class ArrangementType
{
    public function __construct(
        public readonly int $price
    )
    {
    }
}