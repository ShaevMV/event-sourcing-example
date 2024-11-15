<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\ArrangementFee;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasUpdatePrice;
use Shared\Domain\Bus\Projection\Projection;
use Shared\Infrastructure\Projection\BaseProjection;

class ArrangementFeeUpdatePriceProjection extends BaseProjection implements Projection
{
    public function listenTo(): array
    {
        return [
            ArrangementFeeWasUpdatePrice::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (false === $event instanceof ArrangementFeeWasUpdatePrice) {
            return;
        }

        $this->connection->update('arrangement_fee',
            [
                'price' => $event->price,
            ],
            [
                'id' => $event->getAggregateId(),
            ]
        );
    }
}
