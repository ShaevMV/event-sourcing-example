<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use OrganizationalFees\Application\Model\Order;
use OrganizationalFees\Application\Model\OrderRepositoryInterface;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQuery;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws \JsonException|Exception
     */
    public function getOrderList(GetOrderListQuery $query): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $queryOrderList = $qb->from('"order"', 'af')
            ->select(['af.*'])
            ->where($qb->expr()->eq('af.festival_id', ':festivalId'))
            ->setParameter('festivalId', $query->festivalId);

        if (!empty($query->email)) {
            $queryOrderList
                ->innerJoin('af', 'security_user', 'su', $qb->expr()->eq('af.user_id', 'su.id'))
                ->andWhere($qb->expr()->like('su.username', ':email'))
                ->setParameter('email', $query->email);
        }

        if (!empty($query->status)) {
            $queryOrderList
                ->andWhere($qb->expr()->eq('af.status', ':status'))
                ->setParameter('status', $query->status);
        }

        if (!empty($query->price)) {
            $queryOrderList
                ->andWhere($qb->expr()->eq('af.price', ':price'))
                ->setParameter('price', $query->price);
        }

        if (!empty($query->promoCode)) {
            $queryOrderList
                ->andWhere($qb->expr()->eq('af.promo_code', ':promoCode'))
                ->setParameter('promoCode', $query->promoCode);
        }

        $orderList = $queryOrderList->fetchAllAssociative();

        return array_map(fn (array $data) => new Order(
            $data['id'],
            json_decode($data['guest'], true),
            $data['type_arrangement_id'],
            $data['user_id'],
            $data['status'],
            $data['price'],
            $data['total'],
            $data['promo_code'],
            $data['discount'],
        ), $orderList);
    }
}
