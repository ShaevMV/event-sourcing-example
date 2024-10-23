<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use OrganizationalFees\Application\Model\PromoCode;
use OrganizationalFees\Application\Model\PromoCodeRepositoryInterface;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Model\FestivalId;

class PromoCodeRepository implements PromoCodeRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws Exception
     */
    public function findPromoCode(Title $title, FestivalId $festivalId): ?PromoCode
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $promoCode = $qb->from('promo_code', 'pc')
            ->select(['pc.*'])
            ->where('title = :title')
            ->andWhere('festival_id = :festivalId')
            ->setParameters([
                'title' => $title->value(),
                'festivalId' => $festivalId->value(),
            ])
            ->fetchAssociative();

        if ($promoCode) {
            return new PromoCode(
                $promoCode['id'],
                $promoCode['title'],
                $promoCode['discount'],
                $promoCode['festival_id'],
                $promoCode['sing'],
                $promoCode['limit_count'],
            );
        }

        return null;
    }
}
