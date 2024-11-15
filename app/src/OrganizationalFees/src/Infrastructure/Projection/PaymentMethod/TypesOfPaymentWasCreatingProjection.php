<?php

declare(strict_types=1);

namespace OrganizationalFees\Infrastructure\Projection\PaymentMethod;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Domain\PaymentMethod\Event\PaymentMethodWasCreating;
use Shared\Domain\Bus\Projection\Projection;
use Shared\Infrastructure\Projection\BaseProjection;

class TypesOfPaymentWasCreatingProjection extends BaseProjection implements Projection
{
    public function listenTo(): array
    {
        return [
            PaymentMethodWasCreating::class,
        ];
    }

    /**
     * @throws Exception
     */
    public function project(mixed $event): void
    {
        if (false === $event instanceof PaymentMethodWasCreating) {
            return;
        }

        $this->connection->insert('payment_method',
            [
                'id' => $event->getAggregateId(),
                'account_details' => $event->accountDetails,
                'festival_id' => $event->festivalId,
                'active' => $event->active,
                '"order"' => $event->order,
            ],
        );
    }
}
