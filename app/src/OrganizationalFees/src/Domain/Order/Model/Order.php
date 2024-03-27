<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Event\OrderWasCreating;
use Auth\Domain\User\Model\UserId;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class Order extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    private readonly array $guestNames;
    public readonly ArrangementId $arrangementTypeId;

    private OrderStatus $status;

    private readonly UserId $userId;
    private readonly PromoCode $promoCode;


    public static function create(
        array         $guestNames,
        ArrangementFee $arrangementFee,
        UserId        $userId,
        PromoCode     $promoCode,
    ): self
    {
        $order = new self(OrderId::random());

        $order->recordAndApply(new OrderWasCreating(
            $order->id()->value(),
            $guestNames,
            $userId->value(),
            $arrangementFee->id()->value(),
            $promoCode->value(),
            $arrangementFee->getPrice(time())
        ));

        return $order;
    }

    public function onOrderWasCreating(OrderWasCreating $orderWasCreating): void
    {
        $this->id = OrderId::fromString($orderWasCreating->getAggregateId());
        $this->status = OrderStatus::fromString(OrderStatus::NEW);
        $this->guestNames = array_map(fn(string $name) => GuestName::fromString($name), $orderWasCreating->guestNames);
        $this->arrangementTypeId = ArrangementId::fromString($orderWasCreating->arrangementFeeId);
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