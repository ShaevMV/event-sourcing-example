<?php

namespace OrganizationalFees\Domain\Order\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\ValueObject\Uuid;

class OrderId extends Uuid implements AggregateId
{
}
