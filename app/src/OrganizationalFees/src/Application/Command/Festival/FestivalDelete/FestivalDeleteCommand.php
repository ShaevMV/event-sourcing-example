<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalDelete;

use Shared\Domain\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class FestivalDeleteCommand implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,
    ) {
    }
}
