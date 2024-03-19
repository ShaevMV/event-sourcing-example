<?php

declare(strict_types=1);

namespace Tests\ArrangementFee\Domain\Order\Model;

use Auth\Domain\User\Model\UserId;
use ArrangementFee\Domain\Order\Event\OrderWasCreating;
use ArrangementFee\Domain\Order\Model\Order;
use ArrangementFee\Domain\Order\Model\PromoCode;
use ArrangementFee\Domain\Order\Model\TicketTypeId;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCreate():void
    {
        $order = Order::create(
            ['test1','test2'],
            TicketTypeId::random(),
            UserId::random(),
            PromoCode::fromString('')
        );

        $events = $order->pullEvents();
        $this->assertCount(1, $events);

        /** @var OrderWasCreating $orderWasCreating */
        $orderWasCreating = $events->current();
        $this->assertInstanceOf(OrderWasCreating::class, $orderWasCreating);
        $this->assertSame($order->id()->value(), $orderWasCreating->getAggregateId());
        $this->assertSame(['test1','test2'], $orderWasCreating->guestNames);
    }
}