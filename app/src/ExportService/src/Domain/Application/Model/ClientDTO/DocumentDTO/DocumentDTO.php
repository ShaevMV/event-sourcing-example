<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\DocumentDTO;

final class DocumentDTO
{
    public function __construct(
        public readonly ClientInn $inn,
        public readonly ClientSnils $snils,
    )
    {
    }
}