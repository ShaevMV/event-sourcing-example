<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\OrderCreate;

use Shared\Domain\Bus\Command\CommandResponse;

class OrderCreateCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly string $orderId,
    ) {
    }
}
