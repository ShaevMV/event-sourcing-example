<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model\ClientDTO;

use ExportService\Domain\Application\Model\ClientDTO\AddressDTO\AddressDTO;
use ExportService\Domain\Application\Model\ClientDTO\ContactDTO\ContactDTO;
use ExportService\Domain\Application\Model\ClientDTO\DocumentDTO\DocumentDTO;
use ExportService\Domain\Application\Model\ClientDTO\NameDTO\NameDTO;
use ExportService\Domain\Application\Model\ClientDTO\PassportDTO\PassportDTO;

final class ClientDTO
{

    /**
     * "client": {
    "id": 495441,
    "archi_id": 2373931,
    "created_at": "2022-12-22T05:59:30+03:00",
    "documents": {
    "inn": "",
    "snils": ""
    },
    "name": {
    "first": "Авто-Максимильян",
    "last": "Захаров",
    "patronymic": "Федоровна"
    },
    "old_name": null,
    "passport": {
    "series": "9396",
    "number": "208853",
    "issued_at": "2020-06-01T00:00:00+03:00",
    "issuer": "Автоматизированным отделом УФСБ по с. Оймякон",
    "department_code": "453-866"
    },
    "old_passport": null,
    "contact": {
    "mobile_phone": "79666580014",
    "email": "nifont1985@autotestdzp.test"
    },
    "birth": {
    "date": "1968-01-03T00:00:00+03:00",
    "place": "п. Югорск"
    },
    "address": {
    "registration": {
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
    "residence": null
    }
    }
     */

    public function __construct(
        public readonly ClientId $clientId,
        public readonly ?ArchiId $archiId,
        public readonly CreatedAt $createdAt,
        public readonly DocumentDTO $document,
        public readonly NameDTO $name,
        public readonly PassportDTO $passport,
        public readonly ContactDTO $contact,
        public readonly AddressDTO $address,

    )
    {
    }

}