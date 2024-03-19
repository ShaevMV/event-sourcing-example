<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Command\OrderCreate;

use Shared\Domain\Bus\Command\Command;

class OrderCreateCommand implements Command
{
    public function __construct(
        public readonly array $guestNames,
        public readonly string $userId,
        public readonly string $ticketTypeId,
        public readonly string $promoCode
    )
    {
    }
}