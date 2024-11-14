<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Event;

use Shared\Domain\Bus\Event\Event;

class FestivalWasEdit extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly string $name,
        public readonly \DateTimeImmutable $dateStart,
        public readonly \DateTimeImmutable $dateEnd,
        public readonly string $pdfTemplate,
        public readonly string $mailTemplate,
    ) {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'organizationalFees.domain.festival.edit';
    }
}
