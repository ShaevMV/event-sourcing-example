<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalCreate;

use Shared\Domain\Bus\Command\CommandResponse;

class FestivalCreateCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}