<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\GetFestivalList;

use OrganizationalFees\Application\Model\Festival\FestivalRepositoryInterface;
use Shared\Domain\Bus\Query\QueryHandler;

class GetFestivalListQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FestivalRepositoryInterface $festivalRepository,
    ) {
    }

    public function __invoke(GetFestivalListQuery $query): GetFestivalListQueryResponse
    {
        return new GetFestivalListQueryResponse($this->festivalRepository->getFestivalList());
    }
}
