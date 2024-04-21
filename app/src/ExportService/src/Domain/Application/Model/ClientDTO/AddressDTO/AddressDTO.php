<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\AddressDTO;

use ExportService\Domain\Application\Model\ClientDTO\AddressDTO\RegistrationDTO\RegistrationDTO;

final class AddressDTO
{
    public function __construct(
        public readonly RegistrationDTO $registration,
        public readonly ?Residence $residence,
    )
    {
    }
}