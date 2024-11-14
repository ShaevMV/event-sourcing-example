<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalEdit;

use Shared\Domain\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class FestivalEditCommand implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,

        #[Assert\NotBlank]
        public readonly string $name,

        #[Assert\Date]
        #[Assert\NotBlank]
        public readonly string $dateStart,
        #[Assert\Date]
        #[Assert\NotBlank]
        public readonly string $dateEnd,

        #[Assert\NotBlank]
        public readonly string $mailTemplate,
        #[Assert\NotBlank]
        public readonly string $pdfTemplate,
    ) {
    }
}
