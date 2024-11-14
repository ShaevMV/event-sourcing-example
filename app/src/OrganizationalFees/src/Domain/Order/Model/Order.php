<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementPriceTimestamp;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\Order\Event\OrderWasApproved;
use OrganizationalFees\Domain\Order\Event\OrderWasCreating;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ValueObject\Status;
use Shared\Domain\ValueObject\ValidateException;

class Order extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    public readonly GuestList $guestNames;
    public readonly ArrangementId $arrangementFeeId;

    private OrderStatus $status;

    public readonly UserId $userId;
    public readonly ?Title $promoCode;

    public readonly OrderPrice $price;
    public readonly OrderDiscount $discount;
    public readonly OrderTotalPrice $total;
    public readonly FestivalId $festivalId;

    /**
     * @throws ValidateException
     */
    public static function create(
        GuestList $guestNames,
        ArrangementFee $arrangementFee,
        UserId $userId,
        ?PromoCode $promoCode = null,
    ): self {
        $order = new self(OrderId::random());

        $promoCode?->validateCountAchievedLimit();
        $correctPrice = $arrangementFee->getPrice()->getCorrectPrice(new ArrangementPriceTimestamp(time()))->value();
        $totalPrice = new OrderTotalPrice(
            $correctPrice,
            $guestNames->toCount()
        );
        $totalPriceDiscount = $promoCode?->calculateDiscount($totalPrice);

        $order->recordAndApply(new OrderWasCreating(
            $order->id()->value(),
            $guestNames->toArray(),
            $userId->value(),
            $arrangementFee->id()->value(),
            $correctPrice,
            $totalPrice->applyDiscount($totalPriceDiscount)->value(),
            $arrangementFee->festivalId->value(),
            $totalPriceDiscount?->value() ?? 0,
            $promoCode?->getTitle()->value() ?? null,
        ));

        return $order;
    }

    /**
     * @throws ValidateException
     */
    public function onOrderWasCreating(OrderWasCreating $orderWasCreating): void
    {
        $this->id = OrderId::fromString($orderWasCreating->getAggregateId());

        $this->guestNames = GuestList::fromArray($orderWasCreating->guestNames);
        $this->userId = new UserId($orderWasCreating->userId);
        $this->status = new OrderStatus(Status::fromString(Status::NEW), $this->userId);
        $this->arrangementFeeId = ArrangementId::fromString($orderWasCreating->arrangementFeeId);
        $this->price = new OrderPrice($orderWasCreating->price);
        $this->promoCode = ($orderWasCreating->promoCode ?? false) ? new Title($orderWasCreating->promoCode) : null;
        $this->discount = new OrderDiscount($orderWasCreating->discount);
        $this->festivalId = new FestivalId($orderWasCreating->festivalId);
        $this->total = new OrderTotalPrice($orderWasCreating->total);
    }

    /**
     * @throws \Exception
     */
    public function approved(UserId $userId): self
    {
        if ($this->status->status->isCorrectNextStatus(new Status(Status::APPROVED))) {
            $this->recordAndApply(new OrderWasApproved(
                $this->id->value(),
                $userId->value(),
            ));
        } else {
            throw new \DomainException("Нельзя перевести заказ с {$this->status->status->value()} в ".Status::APPROVED);
        }

        return $this;
    }

    public function onOrderWasApproved(OrderWasApproved $orderWasApproved): void
    {
        $this->status = new OrderStatus(
            Status::fromString(Status::APPROVED),
            new UserId($orderWasApproved->userId)
        );
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }
}
