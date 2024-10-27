<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\Order;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\Order\Event\OrderWasApproved;
use Shared\Domain\Bus\Projection\Projection;

class OrderWasModifyStatusProjection implements Projection
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function listenTo(): array
    {
        return [
            OrderWasApproved::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (false === $event instanceof OrderWasApproved) {
            return;
        }

        $this->connection->update('"order"',
            [
                'status' => $event->getStatus(),
            ],
            [
                'id' => $event->getAggregateId(),
            ]
        );
    }
}
