<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Query\PromoCode\FindPromoCode;

use OrganizationalFees\Application\Model\PromoCode\PromoCodeRepositoryInterface;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Bus\Query\QueryHandler;

class FindPromoCodeQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly PromoCodeRepositoryInterface $repository,
    ) {
    }

    public function __invoke(FindPromoCodeQuery $query): ?FindPromoCodeQueryResponse
    {
        $promoCode = $this->repository->findPromoCode(
            Title::fromString($query->title),
            FestivalId::fromString($query->festivalId),
        );

        if (null === $promoCode) {
            return null;
        }

        return new FindPromoCodeQueryResponse(
            $promoCode->id,
            $promoCode->discount,
        );
    }
}
