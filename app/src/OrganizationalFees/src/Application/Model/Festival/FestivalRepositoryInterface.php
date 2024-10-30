<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\Festival;

interface FestivalRepositoryInterface
{
    public function getFestivalList(): array;

    public function getActiveFestival(\DateTime $dateTimeNow): ?Festival;
}
