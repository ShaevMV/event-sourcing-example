<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\FestivalCreate;

use DateTime;
use Shared\Domain\Bus\Command\Command;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FestivalCreateCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly DateTime $dateStart,
        public readonly DateTime $dateEnd,
        public readonly UploadedFile $mailTemplate,
        public readonly UploadedFile $pdfTemplate,
    )
    {
    }
}