<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Shared\Domain\ValueObject\Status;
use Shared\Domain\ValueObject\Uuid;

class OrderStatus
{
    public function __construct(
        public Status $status,
        public Uuid $userModified,
    )
    {
    }
}
