<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\ArrangementFee;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasUpdatePrice;
use Shared\Domain\Bus\Projection\Projection;

class ArrangementFeeUpdatePriceProjection implements Projection
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

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
        if (false === $event instanceof ArrangementFeeWasCreating) {
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
