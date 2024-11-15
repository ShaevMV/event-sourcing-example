<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\Order\OrderCreate;

use App\DataFixtures\UserFixture;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\Order\OrderCreate\OrderCreateCommand;
use OrganizationalFees\Application\Command\Order\OrderCreate\OrderCreateCommandHandler;
use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\OrderId;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Application\Command\ArrangementFee\AddArrangementFee\AddArrangementFeeCommandHandlerTest;
use Tests\OrganizationalFees\Application\Command\PromoCode\AddPromoCodeCommandHandlerTest;
use Tests\OrganizationalFees\Constant\TestConstant;

class OrderCreateCommandTest extends InfrastructureTestCase
{
    use ReadModelTrait;

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     * @throws Exception
     * @throws \Exception
     */
    public function testCreate(): Order
    {
        /** @var AddPromoCodeCommandHandlerTest $addPromoCodeCommandHandlerTest */
        $addPromoCodeCommandHandlerTest = $this->get(AddPromoCodeCommandHandlerTest::class);
        $promoCode = $addPromoCodeCommandHandlerTest->testCreate();
        /** @var AddArrangementFeeCommandHandlerTest $addArrangementFeeCommandHandlerTest */
        $addArrangementFeeCommandHandlerTest = $this->get(AddArrangementFeeCommandHandlerTest::class);
        $arrangementFee = $addArrangementFeeCommandHandlerTest->testCreate();

        /** @var OrderCreateCommandHandler $handler */
        $handler = $this->get(OrderCreateCommandHandler::class);
        $orderResponse = $handler(new OrderCreateCommand(
            ['test1', 'test2'],
            UserFixture::USER_ID,
            $arrangementFee->id()->value(),
            TestConstant::FESTIVAL_ID,
            $promoCode->getTitle()->value(),
        ));

        $orderId = OrderId::fromString($orderResponse->orderId);
        /** @var OrderRepositoryPersistence $orderRepositoryPersistence */
        $orderRepositoryPersistence = $this->get(OrderRepositoryPersistence::class);
        $order = $orderRepositoryPersistence->ofId(OrderId::fromString($orderResponse->orderId));
        self::assertTrue($orderId->equals(OrderId::fromString($order->id()->value())));

        $orderArr = $this->getReadModel('"order"', $orderId->value());

        self::assertNotEmpty($orderArr);

        return $order;
    }
}
