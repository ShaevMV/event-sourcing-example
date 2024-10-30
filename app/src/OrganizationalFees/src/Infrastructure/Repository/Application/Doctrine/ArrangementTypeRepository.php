<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use OrganizationalFees\Application\Model\ArrangementFee\ArrangementFee;
use OrganizationalFees\Application\Model\ArrangementFee\ArrangementFeeRepositoryInterface;
use Shared\Domain\Model\FestivalId;

class ArrangementTypeRepository implements ArrangementFeeRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws Exception
     * @throws \DateMalformedStringException
     */
    public function getList(FestivalId $festivalId): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $arrangementFeeList = $qb->from('arrangement_fee', 'af')
            ->select(['af.*'])
            ->andWhere('festival_id = :festivalId')
            ->setParameters([
                'festivalId' => $festivalId->value(),
            ])
            ->fetchAllAssociative();

        return array_map(fn (array $arrangementFee) => new ArrangementFee(
            $arrangementFee['id'],
            $arrangementFee['name'],
            $arrangementFee['festival_id'],
            $arrangementFee['price'],
            (new \DateTime($arrangementFee['updated_at']))->format('Y-m-d H:i:s'),
        ), $arrangementFeeList);
    }

    /**
     * @throws Exception|\DateMalformedStringException
     */
    public function getListAllPrice(FestivalId $festivalId): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $arrangementFeeList = $qb->from('arrangement_fee', 'af')
            ->select([
                'af.id',
                'af.name',
                'af.festival_id',
                'afp.price',
                'afp.timestamp',
            ])
            ->innerJoin('af', 'arrangement_fee_price', 'afp', $qb->expr()->eq('af.id', 'afp.arrangement_fee_id'))
            ->andWhere('festival_id = :festivalId')
            ->setParameters([
                'festivalId' => $festivalId->value(),
            ])
            ->fetchAllAssociative();

        return array_map(fn (array $arrangementFee) => new ArrangementFee(
            $arrangementFee['id'],
            $arrangementFee['name'],
            $arrangementFee['festival_id'],
            $arrangementFee['price'],
            (new \DateTimeImmutable())->setTimestamp($arrangementFee['timestamp'])->format('Y-m-d H:i:s'),
        ), $arrangementFeeList);
    }
}
