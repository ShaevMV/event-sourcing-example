<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Festival\FindFestival;

use Shared\Domain\Bus\Query\Query;
use Symfony\Component\Validator\Constraints as Assert;

class FindFestivalQuery implements Query
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public readonly ?string $id,
    ) {
    }
}
