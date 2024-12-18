<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use OrganizationalFees\Application\Model\Festival\Festival;
use OrganizationalFees\Application\Model\Festival\FestivalRepositoryInterface;
use OrganizationalFees\Domain\Festival\Model\FestivalId;

class FestivalRepository implements FestivalRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws Exception
     */
    public function getFestivalList(): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $festivalList = $qb->select('f.*')
            ->from('festival', 'f')
            ->fetchAllAssociative();

        return array_map(fn (array $festival) => new Festival(
            $festival['id'],
            $festival['name'],
            $festival['date_start'],
            $festival['date_end'],
            $festival['pdf_template'],
            $festival['mail_template'],
            $festival['created_at'],
            $festival['updated_at'],
        ), $festivalList);
    }

    /**
     * @throws Exception
     */
    public function getActiveFestival(\DateTime $dateTimeNow): ?Festival
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $dateTimeNowString = $dateTimeNow->format('Y-m-d H:i:s');
        $festival = $qb->select('f.*')
            ->from('festival', 'f')
            ->where('date_start <= :dateNow')
            ->andWhere('date_end >= :dateNow')
            ->setParameter('dateNow', $dateTimeNowString)
            ->fetchAssociative();

        if ($festival) {
            return new Festival(
                $festival['id'],
                $festival['name'],
                $festival['date_start'],
                $festival['date_end'],
                $festival['pdf_template'],
                $festival['mail_template'],
                $festival['created_at'],
                $festival['updated_at'],
            );
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function find(FestivalId $id): ?Festival
    {
        $qb = new QueryBuilder($this->em->getConnection());

        $festival = $qb->select('f.*')
            ->from('festival', 'f')
            ->where('f.id = :festivalId')
            ->setParameter('festivalId', $id->value())
            ->fetchAssociative();

        if ($festival) {
            return new Festival(
                $festival['id'],
                $festival['name'],
                $festival['date_start'],
                $festival['date_end'],
                $festival['pdf_template'],
                $festival['mail_template'],
                $festival['created_at'],
                $festival['updated_at'],
            );
        }

        return null;
    }
}
