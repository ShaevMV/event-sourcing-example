<?php

namespace OrganizationalFees\Infrastructure\Projection\Order;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Event\OrderWasCreating;
use OrganizationalFees\Domain\Order\Model\OrderStatus;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\ArrangementFeeRepositoryDecoration;
use OrganizationalFees\Infrastructure\Service\PriceService;
use Shared\Domain\Bus\Event\Event;
use Shared\Domain\Bus\Projection\Projection;

class OrderWasCreatingProjection implements Projection
{
    public function __construct(
        private readonly Connection $connection,

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

        $this->connection->insert('order',
            [
                'id' => $event->getAggregateId(),
                'guest' => json_encode($event->guestNames),
                'user_id' => $event->userId,
                'arrangement_fee_id' => $event->arrangementFeeId,
                'status' => OrderStatus::NEW,
                'price' => $event->price,
                'promo_code' => $event->promoCode,
            ],
        );
    }
}