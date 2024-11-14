<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\TypesOfPayment\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\ValueObject\Uuid;

class TypesOfPaymentId extends Uuid implements AggregateId
{
}
