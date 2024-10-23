<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\AddPromoCode;

use Shared\Domain\Bus\Command\Command;

class AddPromoCodeCommand implements Command
{
    public function __construct(
        public readonly string $title,
        public readonly int $discount,
        public readonly string $festivalId,
        public readonly string $sing,
        public readonly ?int $limit = null,
    ) {
    }
}
