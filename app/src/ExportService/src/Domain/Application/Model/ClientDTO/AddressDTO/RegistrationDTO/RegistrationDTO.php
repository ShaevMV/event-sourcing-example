<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO\AddressDTO\RegistrationDTO;

final class RegistrationDTO
{
    /**
     * "registration": {
    "full": "",
    "country_text": "Россия",
    "country_code": "643",
    "post_index": "",
    "city": "Архыз",
    "street": "Петровская",
    "district": "",
    "house": "40",
    "block": "",
    "building": "",
    "letter": "",
    "apartment": "396"
    },
     */

    public function __construct(
        public readonly Full $full,
        public readonly CountryText $countryText,
        public readonly CountryCode $countryCode,
        public readonly PostIndex $postIndex,
        public readonly City $city,
        public readonly Street $street,
        public readonly District $district,
        public readonly House $house,
        public readonly Block $block,
        public readonly Building $building,
        public readonly Letter $letter,
        public readonly Apartment $apartment,
    )
    {
    }
}