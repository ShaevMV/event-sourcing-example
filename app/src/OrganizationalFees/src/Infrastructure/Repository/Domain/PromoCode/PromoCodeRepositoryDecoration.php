<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Domain\PromoCode;

use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeRepositoryPersistence;

class PromoCodeRepositoryDecoration
{
    public function __construct(
        public readonly PromoCodeRepositoryPersistence $promoCodeRepositoryPersistence,
    ) {
    }

    public function ofId(PromoCodeId $id): PromoCode
    {
        return $this->promoCodeRepositoryPersistence->ofId($id);
    }

    public function persist(PromoCode $promoCode): void
    {
        $this->promoCodeRepositoryPersistence->persist($promoCode);
    }
}
