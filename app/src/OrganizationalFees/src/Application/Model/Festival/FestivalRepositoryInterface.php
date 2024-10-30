<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\Festival;

use Shared\Domain\ValueObject\DateTime;

interface FestivalRepositoryInterface
{
    public function getFestivalList(): array;

    public function getActiveFestival(DateTime $dateTimeNow): ?Festival;
}
