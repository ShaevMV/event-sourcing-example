<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\ArrangementFee\UpdatePrice;

use Shared\Domain\Bus\Command\Command;

class UpdatePriceCommand implements Command
{
    public function __construct(
        public readonly string $arrangementFeeId,
        public readonly int $price,
        public readonly int $timestamp,
    ) {
    }
}
