<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\PaymentMethod\PaymentMethodCreate;

use Shared\Domain\Bus\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class PaymentMethodCreateCommand implements Command
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $accountDetails,
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public readonly string $festivalId,

        #[Assert\NotBlank]
        #[Assert\Type('boolean')]
        public readonly bool $active,

        #[Assert\Type('integer')]
        #[Assert\NotBlank]
        public readonly int $order,
    ) {
    }
}
