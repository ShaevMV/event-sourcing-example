<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Model;

interface PromoCodeRepositoryPersistence
{
    public function ofId(PromoCodeId $id): PromoCode;

    public function persist(PromoCode $object): void;
}
