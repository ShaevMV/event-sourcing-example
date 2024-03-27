<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\OrderCreate;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use OrganizationalFees\Domain\Order\Model\PromoCode;
use Auth\Domain\User\Model\UserId;
use Shared\Domain\Bus\Command\CommandHandler;

class OrderCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly OrderRepositoryPersistence $orderRepositoryPersistence,
        private readonly ArrangementFeeRepositoryPersistence $feeRepositoryDecoration
    )
    {
    }

    public function __invoke(OrderCreateCommand $orderCreateCommand): OrderCreateCommandResponse
    {
        $arrangementFee = $this->feeRepositoryDecoration->ofId(ArrangementId::fromString($orderCreateCommand->ticketTypeId));

        $order = Order::create(
            $orderCreateCommand->guestNames,
            $arrangementFee,
            UserId::fromString($orderCreateCommand->userId),
            PromoCode::fromString($orderCreateCommand->promoCode)
        );

        $this->orderRepositoryPersistence->persist($order);

        return new OrderCreateCommandResponse($order->id()->value());
    }
}