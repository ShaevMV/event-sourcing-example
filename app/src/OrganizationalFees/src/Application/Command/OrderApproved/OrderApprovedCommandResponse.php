<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\OrderApproved;

use Shared\Domain\Bus\Command\CommandResponse;

class OrderApprovedCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message = '',
    ) {
    }
}
