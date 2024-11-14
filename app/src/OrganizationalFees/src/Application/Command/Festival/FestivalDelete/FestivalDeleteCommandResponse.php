<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalDelete;

use Shared\Domain\Bus\Command\CommandResponse;

class FestivalDeleteCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly bool $success,
    ) {
    }
}
