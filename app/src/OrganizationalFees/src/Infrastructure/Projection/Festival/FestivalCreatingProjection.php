<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\Festival;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\Festival\Event\FestivalWasCreating;
use Shared\Domain\Bus\Projection\Projection;

class FestivalCreatingProjection implements Projection
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }


    public function listenTo(): array
    {
        return [
            FestivalWasCreating::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (false === $event instanceof FestivalWasCreating) {
            return;
        }

        $this->connection->insert('festival',
            [
                'id' => $event->getAggregateId(),
                'name' => $event->name,
                'date_start' => $event->dateStart->format('Y-m-d\TH:i:s.u'),
                'date_end' => $event->dateEnd->format('Y-m-d\TH:i:s.u'),
                'pdf_template' => $event->pdfTemplate,
                'mail_template' => $event->mailTemplate,
            ],
        );
    }
}