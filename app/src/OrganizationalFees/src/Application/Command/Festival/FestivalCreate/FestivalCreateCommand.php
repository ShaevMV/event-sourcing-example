<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalCreate;

use DateTime;
use Shared\Domain\Bus\Command\Command;
use Symfony\Component\HttpFoundation\File\File;

class FestivalCreateCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly DateTime $dateStart,
        public readonly DateTime $dateEnd,
        public readonly File $mailTemplate,
        public readonly File $pdfTemplate,
    )
    {
    }
}