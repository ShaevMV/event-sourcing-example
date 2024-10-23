<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\ValueObject\Uuid;

class ArrangementId extends Uuid implements AggregateId
{
}
