<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalEdit;

use Shared\Domain\Bus\Command\CommandResponse;

class FestivalEditCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly bool $success,
    ) {
    }
}
