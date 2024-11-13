<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\Festival\FindActiveFestival;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Infrastructure\Repository\Application\Doctrine\FestivalRepository;
use Shared\Domain\Bus\Query\QueryHandler;

class FindActiveFestivalQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly FestivalRepository $repository,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     * @throws Exception
     */
    public function __invoke(FindActiveFestivalQuery $query): FindActiveFestivalQueryResponse
    {
        return new FindActiveFestivalQueryResponse(
            $this->repository->getActiveFestival(new \DateTime($query->dateNow))
        );
    }
}
