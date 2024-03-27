<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Model;

use Shared\Domain\ValueObject\PositiveNumber;

class Limit extends PositiveNumber
{
    public function includes(int $count): bool
    {
        return $this->value > $count;
    }
}