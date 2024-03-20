<?php

namespace ArrangementFee\Infrastructure\Projection\Order;

use ArrangementFee\Domain\Order\Event\OrderWasCreating;
use ArrangementFee\Domain\Order\Model\OrderStatus;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Shared\Domain\Bus\Event\Event;
use Shared\Domain\Bus\Projection\Projection;

class OrderWasCreatingProjection implements Projection
{
    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function listenTo(): array
    {
        return [
            OrderWasCreating::class
        ];
    }

    /**
     * @param Event|OrderWasCreating $event
     *
     * @throws Exception
     */
    public function project($event): void
    {
        if (false === $event instanceof OrderWasCreating) {
            return;
        }

        $this->connection->insert('arrangement_fee',
            [
                'id' => $event->getAggregateId(),
                'guest' => json_encode($event->guestNames),
                'user_id' => $event->userId,
                'type_arrangement_id' => $event->arrangementTypeId,
                'status' => OrderStatus::NEW,
            ],
        );
    }
}