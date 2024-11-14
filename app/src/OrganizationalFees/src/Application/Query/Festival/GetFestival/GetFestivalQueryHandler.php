<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Festival\GetFestival;

use OrganizationalFees\Application\Model\Festival\FestivalRepositoryInterface;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use Shared\Domain\Bus\Query\QueryHandler;

class GetFestivalQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FestivalRepositoryInterface $repository,
    ) {
    }

    public function __invoke(GetFestivalQuery $query): ?GetFestivalQueryResponse
    {
        $festival = $this->repository->find(FestivalId::fromString($query->id));

        if (null !== $festival) {
            return new GetFestivalQueryResponse($festival);
        }

        return null;
    }
}
