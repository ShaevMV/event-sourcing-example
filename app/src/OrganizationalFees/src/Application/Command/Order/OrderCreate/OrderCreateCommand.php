<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Order\OrderCreate;

use Shared\Domain\Bus\Command\Command;

class OrderCreateCommand implements Command
{
    public function __construct(
        public readonly array $guestNames,
        public readonly string $userId,
        public readonly string $arrangementFeeId,
        public readonly string $festivalId,
        public readonly ?string $promoCode = null,
    ) {
    }
}
