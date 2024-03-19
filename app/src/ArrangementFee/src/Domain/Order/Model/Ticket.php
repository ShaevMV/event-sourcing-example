<?php

declare(strict_types=1);

namespace ArrangementFee\Domain\Order\Model;

class Ticket
{
    public array $guestName;

    public function __construct(
        array $guestName,
        public readonly TicketTypeId $ticketTypeId
    )
    {
        $this->guestName = array_map(fn(string $name) => GuestName::fromString($name), $guestName);
    }
}