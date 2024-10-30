<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\FindActiveFestival;

use Shared\Domain\Bus\Query\Query;

class FindActiveFestivalQuery implements Query
{
    public function __construct(
        public string $dateNow,
    ) {
    }
}
