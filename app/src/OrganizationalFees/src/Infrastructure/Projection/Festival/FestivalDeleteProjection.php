<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\Festival;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\Festival\Event\FestivalWasDelete;
use Shared\Domain\Bus\Projection\Projection;
use Shared\Infrastructure\Projection\BaseProjection;

class FestivalDeleteProjection extends BaseProjection implements Projection
{
    public function listenTo(): array
    {
        return [
            FestivalWasDelete::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (false === $event instanceof FestivalWasDelete) {
            return;
        }

        $this->connection->delete('festival',
            [
                'id' => $event->getAggregateId(),
            ]
        );
    }
}
