<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\ArrangementFee;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use Shared\Domain\Bus\Projection\Projection;
use Shared\Infrastructure\Projection\BaseProjection;

class ArrangementFeeCreatingProjection extends BaseProjection implements Projection
{
    public function listenTo(): array
    {
        return [
            ArrangementFeeWasCreating::class,
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

        $this->connection->insert('arrangement_fee',
            [
                'id' => $event->getAggregateId(),
                'name' => $event->name,
                'festival_id' => $event->festivalId,
                'price' => $event->price,
            ],
        );
    }
}
