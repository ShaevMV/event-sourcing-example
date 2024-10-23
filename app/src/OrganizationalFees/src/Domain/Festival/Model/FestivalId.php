<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\Model\FestivalId as BaseFestivalId;

class FestivalId extends BaseFestivalId implements AggregateId
{
}
