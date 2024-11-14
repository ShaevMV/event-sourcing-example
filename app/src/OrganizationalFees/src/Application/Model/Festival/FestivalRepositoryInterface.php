<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\Festival;

use OrganizationalFees\Domain\Festival\Model\FestivalId;

interface FestivalRepositoryInterface
{
    public function getFestivalList(): array;

    public function getActiveFestival(\DateTime $dateTimeNow): ?Festival;

    public function find(FestivalId $id): ?Festival;
}
