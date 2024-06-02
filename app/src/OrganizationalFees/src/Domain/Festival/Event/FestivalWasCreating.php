<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Event;

use Shared\Domain\Bus\Event\Event;
use DateTime;

class FestivalWasCreating extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly string $name,
        public readonly DateTime $dateStart,
        public readonly DateTime $dateEnd,
        public readonly string $pdfTemplate,
        public readonly string $mailTemplate,
    )
    {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'organizationalFees.domain.festival.creating';
    }
}