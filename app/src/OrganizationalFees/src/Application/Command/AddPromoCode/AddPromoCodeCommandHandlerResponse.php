<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\AddPromoCode;

use Shared\Domain\Bus\Command\CommandResponse;

class AddPromoCodeCommandHandlerResponse implements CommandResponse
{
    public function __construct(
        public readonly string $id,
    )
    {
    }
}