<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Event;

use ExportService\Domain\Application\Model\ApplicationDTO\ApplicationDTO;
use ExportService\Domain\Application\Model\ClientDTO\ClientDTO;
use Shared\Domain\Bus\Event\Event;

class ApplicationCreated extends Event
{
    public function __construct(
        string $aggregateId,
        public readonly ClientDTO $clientDTO,
        public readonly ApplicationDTO $applicationDTO,
    )
    {
        parent::__construct($aggregateId);
    }

    public static function eventName(): string
    {
        return 'exportService.domain.application.application.created';
    }
}