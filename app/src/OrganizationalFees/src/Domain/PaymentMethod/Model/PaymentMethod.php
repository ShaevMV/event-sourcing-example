<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PaymentMethod\Model;

use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\PaymentMethod\Event\PaymentMethodWasCreating;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class PaymentMethod extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    /** Способ оплаты номер счёта */
    protected PaymentMethodAccountNumber $accountNumber;
    /** Способ оплаты активирован */
    protected PaymentMethodActivated $active;
    /** Порядок способа оплаты  */
    protected PaymentMethodOfOrder $order;
    protected FestivalId $festivalId;

    public static function create(
        PaymentMethodAccountNumber $accountDetails,
        PaymentMethodActivated $active,
        PaymentMethodOfOrder $order,
        FestivalId $festivalId,
    ): self {
        $typesOfPayment = new self(PaymentMethodId::random());

        $typesOfPayment->recordAndApply(new PaymentMethodWasCreating(
            $typesOfPayment->id->value(),
            $accountDetails->value(),
            $active->value(),
            $order->value(),
            $festivalId->value(),
        ));

        return $typesOfPayment;
    }

    public function onCreate(PaymentMethodWasCreating $typeOfPaymentWasCreating): void
    {
        $this->id = PaymentMethodId::fromString($typeOfPaymentWasCreating->getAggregateId());
        $this->accountNumber = PaymentMethodAccountNumber::fromString($typeOfPaymentWasCreating->accountDetails);
        $this->active = PaymentMethodActivated::formatBool($typeOfPaymentWasCreating->active);
        $this->order = PaymentMethodOfOrder::fromInt($typeOfPaymentWasCreating->order);
        $this->festivalId = FestivalId::fromString($typeOfPaymentWasCreating->festivalId);
    }
}
