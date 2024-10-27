<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\OrderApproved;

use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\Order\Model\OrderId;
use Shared\Domain\Bus\Command\Command;

class OrderApprovedCommand implements Command
{
    public function __construct(
        public OrderId $orderId,
        public UserId $userId,
    ) {
    }
}
