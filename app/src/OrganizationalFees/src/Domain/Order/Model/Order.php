<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Event\OrderWasCreating;
use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

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

    public static function create(
        array          $guestNames,
        ArrangementFee $arrangementFee,
        UserId         $userId,
        ?PromoCode     $promoCode = null,
    ): self
    {
        $order = new self(OrderId::random());

        $promoCode?->validateCountAchievedLimit();

        $order->recordAndApply(new OrderWasCreating(
            $order->id()->value(),
            $guestNames,
            $userId->value(),
            $arrangementFee->id()->value(),
            $arrangementFee->getPrice(time()),
            $order->calculateTotal(
                $arrangementFee->getPrice(time()),
                count($guestNames),
                $promoCode?->getDiscount()->value() ?? 0
            ),
            $promoCode?->getDiscount()->value() ?? 0,
            $promoCode?->getTitle()->value() ?? null,
        ));

        return $order;
    }

    private function calculateTotal(int $price, int $count, int $discount = 0): int
    {
        return ($price * $count) - ($count * $discount);
    }



    public function onOrderWasCreating(OrderWasCreating $orderWasCreating): void
    {
        $this->id = OrderId::fromString($orderWasCreating->getAggregateId());
        $this->status = OrderStatus::fromString(OrderStatus::NEW);
        $this->guestNames = array_map(fn(string $name) => GuestName::fromString($name), $orderWasCreating->guestNames);
        $this->userId = new UserId($orderWasCreating->userId);

        $this->arrangementFeeId = ArrangementId::fromString($orderWasCreating->arrangementFeeId);
        $this->price = $orderWasCreating->price;
        $this->promoCode = ($orderWasCreating->promoCode ?? false) ? new Title($orderWasCreating->promoCode) : null;
        $this->discount = $orderWasCreating->discount;
        $this->total = $orderWasCreating->total;
    }


    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

}