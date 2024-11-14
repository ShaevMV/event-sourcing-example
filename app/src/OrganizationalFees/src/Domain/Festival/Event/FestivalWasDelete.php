<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Event;

use Shared\Domain\Bus\Event\Event;

class FestivalWasDelete extends Event
{
    public function __construct(
        string $aggregateId,
    ) {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'organizationalFees.domain.festival.delete';
    }
}
