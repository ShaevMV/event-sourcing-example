<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Event;

use Shared\Domain\Bus\Event\Event;
use Shared\Domain\ValueObject\Status;

class OrderWasApproved extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly string $userId,
        public readonly string $status = Status::APPROVED,
    ) {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'arrangementFee.domain.order.approved';
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
