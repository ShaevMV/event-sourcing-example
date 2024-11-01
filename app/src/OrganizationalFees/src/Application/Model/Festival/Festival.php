<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\Festival;

class Festival
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $dateStart,
        public readonly string $dateEnd,
        public readonly string $pdfTemplate,
        public readonly string $mailTemplate,
        public readonly string $createdAt,
        public readonly string $updateAt,
    ) {
    }
}
