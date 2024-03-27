<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Domain\Order\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\ArrangementFee\Model\FestivalId;
use OrganizationalFees\Domain\Order\Event\OrderWasCreating;
use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\PromoCode;
use Auth\Domain\User\Model\UserId;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCreate(): void
    {
        $arrangementFee = ArrangementFee::create(
            'test',
            100,
            FestivalId::random(),
        );

        $order = Order::create(
            ['test1', 'test2'],
            $arrangementFee,
            UserId::random(),
            PromoCode::fromString('')
        );

        $events = $order->pullEvents();
        $this->assertCount(1, $events);

        /** @var OrderWasCreating $orderWasCreating */
        $orderWasCreating = $events->current();
        $this->assertInstanceOf(OrderWasCreating::class, $orderWasCreating);
        $this->assertSame($order->id()->value(), $orderWasCreating->getAggregateId());
        $this->assertSame(['test1', 'test2'], $orderWasCreating->guestNames);
        $this->assertSame(100, $orderWasCreating->price);
        $this->assertSame($arrangementFee->id()->value(), $orderWasCreating->arrangementFeeId);
    }
}