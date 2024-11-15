<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PaymentMethod\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\ValueObject\Uuid;

class PaymentMethodId extends Uuid implements AggregateId
{
}
