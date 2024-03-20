<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Model;

class ArrangementType
{
    public function __construct(
        public readonly int $price
    )
    {
    }
}