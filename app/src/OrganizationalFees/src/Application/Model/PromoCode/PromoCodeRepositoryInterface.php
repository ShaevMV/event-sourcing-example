<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\PromoCode;

use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\PromoCode\Model\Title;
interface PromoCodeRepositoryInterface
{
    public function findPromoCode(
        Title          $title,
        FestivalId $festivalId,
    ): ?PromoCode;
}
