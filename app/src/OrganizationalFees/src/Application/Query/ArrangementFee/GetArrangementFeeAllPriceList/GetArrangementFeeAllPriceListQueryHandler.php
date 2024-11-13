<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeAllPriceList;

use OrganizationalFees\Application\Model\ArrangementFee\ArrangementFeeRepositoryInterface;
use Shared\Domain\Model\FestivalId;

class GetArrangementFeeAllPriceListQueryHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetArrangementFeeAllPriceListQuery $query): GetArrangementFeeAllPriceListQueryResponse
    {
        return new GetArrangementFeeAllPriceListQueryResponse(
            $this->repository->getListAllPrice(new FestivalId($query->festivalId))
        );
    }
}
