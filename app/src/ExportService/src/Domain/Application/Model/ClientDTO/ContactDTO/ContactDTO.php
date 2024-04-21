<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\ContactDTO;

final class ContactDTO
{
    /**
     *                 "contact": {
    "mobile_phone": "79666580014",
    "email": "nifont1985@autotestdzp.test"
    },
     */

    public function __construct(
        public readonly MobilePhone $mobilePhone,
        public readonly ContactEmail $contactEmail,
    )
    {
    }
}