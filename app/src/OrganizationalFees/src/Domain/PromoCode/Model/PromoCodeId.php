<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\ValueObject\Uuid;

class PromoCodeId extends Uuid implements AggregateId
{
}
