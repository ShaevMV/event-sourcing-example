<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Domain\Order\Model;

use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\Order\Event\OrderWasCreating;
use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\ValueObject\ValidateException;
use Tests\OrganizationalFees\BaseKernelTestCase;
use Tests\OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeTest;
use Tests\OrganizationalFees\Domain\PromoCode\Model\PromoCodeTest;

class OrderTest extends BaseKernelTestCase
{
    private ArrangementFee $arrangementFee;
    private PromoCode $promoCode;

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     * @throws DomainException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        /** @var ArrangementFeeTest $arrangementFee */
        $arrangementFee = $kernel->getContainer()->get(ArrangementFeeTest::class);
        $this->arrangementFee = $arrangementFee->testCreate();
        /** @var PromoCodeTest $promoCode */
        $promoCode = $kernel->getContainer()->get(PromoCodeTest::class);
        $this->promoCode = $promoCode->testCreateFixNotLimit();
    }

    public function testCreate(): Order
    {
        $order = Order::create(
            ['test1', 'test2'],
            $this->arrangementFee,
            UserId::random(),
            null,
        );

        $events = $order->pullEvents();
        $this->assertCount(1, $events);

        /** @var OrderWasCreating $orderWasCreating */
        $orderWasCreating = $events->current();
        $this->assertInstanceOf(OrderWasCreating::class, $orderWasCreating);
        $this->assertSame($order->id()->value(), $orderWasCreating->getAggregateId());
        $this->assertSame(['test1', 'test2'], $orderWasCreating->guestNames);
        $this->assertSame(100, $orderWasCreating->price);
        $this->assertSame($this->arrangementFee->id()->value(), $orderWasCreating->arrangementFeeId);

        return $order;
    }

    public function testCreateOnPromoCode(): Order
    {
        $order = Order::create(
            ['test1', 'test2'],
            $this->arrangementFee,
            UserId::random(),
            $this->promoCode,
        );
        $this->assertEquals(100, $order->price);
        $this->assertEquals(100, $order->discount);
        $this->assertEquals(0, $order->total);

        return $order;
    }
}
