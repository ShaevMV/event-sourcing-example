<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Order\OrderApproved;

use Shared\Domain\Bus\Command\Command;

class OrderApprovedCommand implements Command
{
    public function __construct(
        public readonly string $orderId,
        public readonly string $userId,
    ) {
    }
}
