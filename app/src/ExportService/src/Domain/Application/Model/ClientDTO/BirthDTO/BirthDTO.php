<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\BirthDTO;

final class BirthDTO
{

    /**
     *                 "birth": {
    "date": "1968-01-03T00:00:00+03:00",
    "place": "п. Югорск"
    },
     */
    public function __construct(
        public readonly BirthDate $birthDate,
        public readonly Place $place,
    )
    {
    }
}