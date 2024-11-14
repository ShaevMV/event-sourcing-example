<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeList;

use OrganizationalFees\Application\Model\ArrangementFee\ArrangementFeeRepositoryInterface;
use OrganizationalFees\Domain\Festival\Model\FestivalId;

class GetArrangementFeeListQueryHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetArrangementFeeListQuery $query): GetArrangementFeeListQueryResponse
    {
        return new GetArrangementFeeListQueryResponse(
            $this->repository->getList(new FestivalId($query->festivalId))
        );
    }
}
