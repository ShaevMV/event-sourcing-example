<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\TypesOfPayment\TypesOfPaymentCreate;

use Shared\Domain\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class TypesOfPaymentCreateCommand implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public readonly string $festivalId,

        #[Assert\NotBlank]
        #[Assert\Type('boolean')]
        public readonly bool $active,

        #[Assert\Type('integer')]
        #[Assert\NotBlank]
        public readonly int $sort,
    ) {
    }
}
