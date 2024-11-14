<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use Shared\Domain\ValueObject\Number;
use Shared\Domain\ValueObject\Timestamp;

class ArrangementPriceTimestamp extends Timestamp
{
    public function lessIsEqual(Number $other): bool
    {
        return $other->value() <= $this->value();
    }
}
