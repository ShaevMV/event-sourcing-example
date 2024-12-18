<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Model\ArrangementFee;

use OrganizationalFees\Domain\Festival\Model\FestivalId;

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
