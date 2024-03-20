<?php

declare(strict_types=1);

namespace ArrangementFee\Infrastructure\Repository\Application\ArrangementFee\Doctrine\Repository;

use ArrangementFee\Application\Model\Order;
use ArrangementFee\Application\Model\ArrangementFeeRepositoryInterface;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;

class ArrangementFeeRepository implements ArrangementFeeRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    /**
     * @inheritDoc
     * @throws JsonException|Exception
     */
    public function getOrderList(): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $orderList = $qb->from('arrangement_fee', 'af')
            ->select(['af.*'])
            ->fetchAllAssociative();

        return array_map(fn(array $data) => new Order(
            $data['id'],
            json_decode($data['guest'], true),
            $data['type_arrangement_id'],
            $data['user_id'],
            $data['status'],
        ), $orderList);
    }
}