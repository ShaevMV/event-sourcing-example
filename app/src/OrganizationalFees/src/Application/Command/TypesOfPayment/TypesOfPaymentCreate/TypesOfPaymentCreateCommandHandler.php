<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\TypesOfPayment\TypesOfPaymentCreate;

use Shared\Domain\Bus\Command\CommandHandler;

class TypesOfPaymentCreateCommandHandler implements CommandHandler
{
    public function __invoke(TypesOfPaymentCreateCommand $command): TypesOfPaymentCreateCommandResponse
    {
        // TODO: Implement __invoke() method.
    }
}
