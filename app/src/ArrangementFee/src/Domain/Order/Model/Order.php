<?php

declare(strict_types=1);

namespace ArrangementFee\Domain\Order\Model;

use Auth\Domain\User\Model\UserId;
use ArrangementFee\Domain\Order\Event\OrderWasCreating;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class Order extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    private readonly array $guestNames;
    public readonly TicketTypeId $ticketTypeId;

    private OrderStatus $status;

    private readonly UserId $userId;
    private readonly PromoCode $promoCode;

    /**
     * @param string[] $guestNames
     * @param TicketTypeId $ticketTypeId
     * @param UserId $userId
     * @param PromoCode $promoCode
     * @return self
     */
    public static function create(
        array $guestNames,
        TicketTypeId $ticketTypeId,
        UserId $userId,
        PromoCode $promoCode,
    ): self
    {
        $order = new self(OrderId::random());
        $order->recordAndApply(new OrderWasCreating(
            $order->id()->value(),
            $guestNames,
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
        $this->guestNames = array_map(fn(string $name) => GuestName::fromString($name), $orderWasCreating->guestNames);
        $this->ticketTypeId = TicketTypeId::fromString($orderWasCreating->ticketTypeId);
        $this->promoCode = new PromoCode($orderWasCreating->promoCode);
        $this->userId = new UserId($orderWasCreating->userId);
    }

    public function getGuestNames(): array
    {
        return $this->guestNames;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getPromoCode(): PromoCode
    {
        return $this->promoCode;
    }
}