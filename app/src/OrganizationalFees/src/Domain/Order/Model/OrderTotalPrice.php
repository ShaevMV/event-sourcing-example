<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Shared\Domain\ValueObject\PositiveNumber;

class OrderTotalPrice extends PositiveNumber
{
    public function __construct(int $value, int $count = 1)
    {
        parent::__construct($value * $count);
    }

    public function applyDiscount(?PositiveNumber $discount): self
    {
        if (null !== $discount) {
            $this->value -= $discount->value();
        }

        return $this;
    }
}
