<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\PassportDTO;

final class PassportDTO
{
    public function __construct(
        public readonly Series $series,
        public readonly PassportNumber $number,
        public readonly IssuedAt $issuedAt,
        public readonly Issuer $issuer,
        public readonly DepartmentCode $departmentCode,
    )
    {
    }
}