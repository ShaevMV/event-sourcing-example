<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\NameDTO;

final class NameDTO
{
    public function __construct(
        public readonly FirstName $firstName,
        public readonly LastName $lastName,
        public readonly Patronymic $patronymic,
    )
    {
    }
}