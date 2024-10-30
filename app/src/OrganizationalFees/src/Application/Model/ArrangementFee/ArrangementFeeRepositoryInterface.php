<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\ArrangementFee;

use Shared\Domain\Model\FestivalId;

interface ArrangementFeeRepositoryInterface
{
    /**
     * @return ArrangementFee[]
     */
    public function getList(FestivalId $festivalId): array;

    /**
     * @return ArrangementFee[]
     */
    public function getListAllPrice(FestivalId $festivalId): array;
}
