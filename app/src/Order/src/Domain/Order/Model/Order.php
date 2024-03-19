<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use Auth\Domain\User\Model\UserId;
use Order\Domain\Order\Event\OrderWasCreating;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class Order extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    private Ticket $ticket;

    private OrderStatus $status;

    private UserId $userId;
    private PromoCode $promoCode;

    /**
     * @param string[] $guestName
     * @param TicketTypeId $ticketTypeId
     * @param UserId $userId
     * @param PromoCode $promoCode
     * @return self
     */
    public static function create(
        array $guestName,
        TicketTypeId $ticketTypeId,
        UserId $userId,
        PromoCode $promoCode,
    ): self
    {
        $order = new self(OrderId::random());
        $order->recordAndApply(new OrderWasCreating(
            $order->id()->value(),
            $guestName,
            $userId->value(),
            $ticketTypeId->value(),
            $promoCode->value()
        ));

        return $order;
    }

    public function onOrderWasCreating(OrderWasCreating $orderWasCreating): void
    {
        $this->id = OrderId::fromString($orderWasCreating->getAggregateId());
        $this->status = OrderStatus::fromString(OrderStatus::NEW);
        $this->ticket = new Ticket(
            $orderWasCreating->guestNames,
            TicketTypeId::fromString($orderWasCreating->ticketTypeId)
        );
        $this->promoCode = new PromoCode($orderWasCreating->promoCode);
        $this->userId = new UserId($orderWasCreating->userId);
    }
}