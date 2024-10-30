<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\PromoCode;

use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Model\FestivalId;

interface PromoCodeRepositoryInterface
{
    public function findPromoCode(
        Title $title,
        FestivalId $festivalId,
    ): ?PromoCode;
}
