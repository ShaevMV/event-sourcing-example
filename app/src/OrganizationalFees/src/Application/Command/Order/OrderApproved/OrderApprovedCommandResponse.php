<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Order\OrderApproved;

use Shared\Domain\Bus\Command\CommandResponse;

class OrderApprovedCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message = '',
    ) {
    }
}
