<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\AddArrangementFee;

use Shared\Domain\Bus\Command\Command;

class AddArrangementFeeCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $festivalId,
        public readonly int $price,
    )
    {
    }
}