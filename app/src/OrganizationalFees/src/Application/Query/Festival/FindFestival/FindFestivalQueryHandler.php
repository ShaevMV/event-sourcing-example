<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Festival\FindFestival;

use OrganizationalFees\Application\Model\Festival\FestivalRepositoryInterface;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use Shared\Domain\Bus\Query\QueryHandler;

class FindFestivalQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FestivalRepositoryInterface $repository
    )
    {
    }

    public function __invoke(FindFestivalQuery $query): ?FindFestivalQueryResponse
    {
        $festival = $this->repository->find(FestivalId::fromString($query->id));

        if (null !== $festival) {
            return new FindFestivalQueryResponse($festival);
        }

        return null;
    }
}