<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\PromoCode;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\PromoCode\Event\PromoCodeWasCreating;
use Shared\Domain\Bus\Projection\Projection;

class PromoCodeWasCreatingProjection implements Projection
{
    public function __construct(
        private readonly Connection $connection,
    )
    {
    }


    public function listenTo(): array
    {
        return [
            PromoCodeWasCreating::class
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (false === $event instanceof PromoCodeWasCreating) {
            return;
        }

        $this->connection->insert('promo_code',
            [
                'id' => $event->getAggregateId(),
                'title' => $event->title,
                'festival_id' => $event->festivalId,
                'discount' => $event->discount,
                'limit_count' => $event->limit,
                'sing' => $event->sing,
            ],
        );
    }
}