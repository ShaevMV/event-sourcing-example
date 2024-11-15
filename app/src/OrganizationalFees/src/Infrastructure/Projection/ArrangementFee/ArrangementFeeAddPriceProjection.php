<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\ArrangementFee;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasUpdatePrice;
use Shared\Domain\Bus\Projection\Projection;
use Shared\Domain\ValueObject\Uuid;
use Shared\Infrastructure\Projection\BaseProjection;

class ArrangementFeeAddPriceProjection extends BaseProjection implements Projection
{
    public function listenTo(): array
    {
        return [
            ArrangementFeeWasUpdatePrice::class,
            ArrangementFeeWasCreating::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (
            false === $event instanceof ArrangementFeeWasUpdatePrice
            && false === $event instanceof ArrangementFeeWasCreating
        ) {
            return;
        }

        $this->connection->insert('arrangement_fee_price',
            [
                'id' => Uuid::random()->value(),
                'arrangement_fee_id' => $event->getAggregateId(),
                'price' => $event->price,
                'timestamp' => $event->timestamp ?? time(),
            ],
        );
    }
}
