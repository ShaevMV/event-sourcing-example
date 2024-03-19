<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

class Ticket
{
    public readonly array $guestName;

    public function __construct(
        array $guestName,
        public readonly TicketTypeId $ticketTypeId
    )
    {
        $this->guestName = array_map(fn(string $name) => GuestName::fromString($name), $guestName);
    }
}