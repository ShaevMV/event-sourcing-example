<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\AddArrangementFee;

use Shared\Domain\Bus\Command\CommandResponse;

class AddArrangementFeeCommandResponse implements CommandResponse
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}