<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
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

class Order extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    public readonly array $guestNames;
    public readonly ArrangementId $arrangementFeeId;

    private OrderStatus $status;

    public readonly UserId $userId;
    public readonly ?Title $promoCode;

    public readonly int $price;
    public readonly int $discount;
    public readonly int $total;
    public readonly FestivalId $festivalId;

    public static function create(
        array $guestNames,
        ArrangementFee $arrangementFee,
        UserId $userId,
        ?PromoCode $promoCode = null,
    ): self {
        $order = new self(OrderId::random());

        $promoCode?->validateCountAchievedLimit();

        $totalPrice = $arrangementFee->getPrice(time()) * count($guestNames);
        $totalPriceDiscount = $promoCode?->calculateDiscount($totalPrice);

        $order->recordAndApply(new OrderWasCreating(
            $order->id()->value(),
            $guestNames,
            $userId->value(),
            $arrangementFee->id()->value(),
            $arrangementFee->getPrice(time()),
            null !== $totalPriceDiscount ? $totalPrice - $totalPriceDiscount : $totalPrice,
            $arrangementFee->festivalId->value(),
            $totalPriceDiscount ?? 0,
            $promoCode?->getTitle()->value() ?? null,
        ));

        return $order;
    }

    public function onOrderWasCreating(OrderWasCreating $orderWasCreating): void
    {
        $this->id = OrderId::fromString($orderWasCreating->getAggregateId());

        $this->guestNames = array_map(fn (string $name) => GuestName::fromString($name), $orderWasCreating->guestNames);
        $this->userId = new UserId($orderWasCreating->userId);
        $this->status = new OrderStatus(Status::fromString(Status::NEW), $this->userId);
        $this->arrangementFeeId = ArrangementId::fromString($orderWasCreating->arrangementFeeId);
        $this->price = $orderWasCreating->price;
        $this->promoCode = ($orderWasCreating->promoCode ?? false) ? new Title($orderWasCreating->promoCode) : null;
        $this->discount = $orderWasCreating->discount;
        $this->festivalId = new FestivalId($orderWasCreating->festivalId);
        $this->total = $orderWasCreating->total;
    }

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
