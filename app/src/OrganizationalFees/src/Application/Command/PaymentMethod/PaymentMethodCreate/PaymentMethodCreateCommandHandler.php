<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\PaymentMethod\PaymentMethodCreate;

use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethod;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodAccountNumber;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodActivated;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodOfOrder;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodPersistence;
use Shared\Domain\Bus\Command\CommandHandler;

class PaymentMethodCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly PaymentMethodPersistence $paymentMethodPersistence,
    ) {
    }

    public function __invoke(PaymentMethodCreateCommand $command): PaymentMethodCreateCommandResponse
    {
        $paymentMethod = PaymentMethod::create(
            PaymentMethodAccountNumber::fromString($command->accountDetails),
            PaymentMethodActivated::formatBool($command->active),
            PaymentMethodOfOrder::fromInt($command->order),
            FestivalId::fromString($command->festivalId),
        );

        $this->paymentMethodPersistence->persist($paymentMethod);

        return new PaymentMethodCreateCommandResponse($paymentMethod->id()->value());
    }
}
