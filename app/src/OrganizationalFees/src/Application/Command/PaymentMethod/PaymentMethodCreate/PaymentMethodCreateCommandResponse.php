<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\PaymentMethod\PaymentMethodCreate;

class PaymentMethodCreateCommandResponse
{
    public function __construct(
        public string $id,
    ) {
    }
}
