<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Repository\Application\Doctrine;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use OrganizationalFees\Application\Model\Order;
use OrganizationalFees\Application\Model\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws \JsonException|Exception
     */
    public function getOrderList(): array
    {
        $qb = new QueryBuilder($this->em->getConnection());
        $orderList = $qb->from('order', 'af')
            ->select(['af.*'])
            ->fetchAllAssociative();

        return array_map(fn (array $data) => new Order(
            $data['id'],
            json_decode($data['guest'], true),
            $data['type_arrangement_id'],
            $data['user_id'],
            $data['status'],
            $data['price'],
            $data['promo_code'],
            $data['discount'],
        ), $orderList);
    }
}
