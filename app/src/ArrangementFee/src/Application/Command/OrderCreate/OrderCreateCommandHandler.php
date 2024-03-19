<?php

declare(strict_types=1);

namespace ArrangementFee\Application\Command\OrderCreate;

use ArrangementFee\Domain\Order\Model\Order;
use ArrangementFee\Domain\Order\Model\OrderRepositoryPersistence;
use ArrangementFee\Domain\Order\Model\PromoCode;
use ArrangementFee\Domain\Order\Model\TicketTypeId;
use Auth\Domain\User\Model\UserId;
use Shared\Domain\Bus\Command\CommandHandler;

class OrderCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly OrderRepositoryPersistence $orderRepositoryPersistence
    )
    {
    }

    public function __invoke(OrderCreateCommand $orderCreateCommand): OrderCreateCommandResponse
    {
        $order = Order::create(
            $orderCreateCommand->guestNames,
            TicketTypeId::fromString($orderCreateCommand->ticketTypeId),
            UserId::fromString($orderCreateCommand->userId),
            PromoCode::fromString($orderCreateCommand->promoCode)
        );

        $this->orderRepositoryPersistence->persist($order);

        return new OrderCreateCommandResponse($order->id()->value());
    }
}