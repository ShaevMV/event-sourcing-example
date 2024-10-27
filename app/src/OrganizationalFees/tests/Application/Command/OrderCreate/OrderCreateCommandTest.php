<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\OrderCreate;

use Auth\Domain\User\Model\UserId;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommand;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandler;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommand;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommandHandler;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommand;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommandHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\OrderId;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory\EsArrangementFeeRepositoryPersistence;
use OrganizationalFees\Infrastructure\Repository\Domain\Order\EventStore\EsOrderRepositoryPersistence;
use OrganizationalFees\Infrastructure\Repository\Domain\PromoCode\EventStory\EsPromoCodeRepositoryPersistence;
use Shared\Domain\Model\FestivalId;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Bus\Projection\Projector\Redis\ProjectorConsumer;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandlerTest;
use Tests\OrganizationalFees\Application\Command\PromoCode\AddPromoCodeCommandHandlerTest;
use Tests\OrganizationalFees\BaseKernelTestCase;
use Tests\OrganizationalFees\Constant\TestConstant;
use Tests\OrganizationalFees\Domain\PromoCode\Model\PromoCodeTest;

class OrderCreateCommandTest extends InfrastructureTestCase
{
    use ReadModelTrait;

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     * @throws Exception
     */
    public function testCreate(): Order
    {
        /** @var AddPromoCodeCommandHandlerTest $addPromoCodeCommandHandlerTest */
        $addPromoCodeCommandHandlerTest = $this->get(AddPromoCodeCommandHandlerTest::class);
        $promoCode = $addPromoCodeCommandHandlerTest->testCreate();
        /** @var AddArrangementFeeCommandHandlerTest $addArrangementFeeCommandHandlerTest */
        $addArrangementFeeCommandHandlerTest = $this->get(AddArrangementFeeCommandHandlerTest::class);
        $arrangementFee  = $addArrangementFeeCommandHandlerTest->testCreate();


        /** @var OrderCreateCommandHandler $handler */
        $handler = $this->get(OrderCreateCommandHandler::class);
        $orderResponse = $handler(new OrderCreateCommand(
            ['test1', 'test2'],
            UserId::random()->value(),
            $arrangementFee->id()->value(),
            TestConstant::FESTIVAL_ID,
            $promoCode->getTitle()->value(),
        ));

        $orderId = OrderId::fromString($orderResponse->orderId);
        /** @var OrderRepositoryPersistence $orderRepositoryPersistence */
        $orderRepositoryPersistence = $this->get(OrderRepositoryPersistence::class);
        $order = $orderRepositoryPersistence->ofId(OrderId::fromString($orderResponse->orderId));
        self::assertTrue($orderId->equals(OrderId::fromString($order->id()->value())));

        $this->consumer();
        $this->getReadModel('"order"',$orderId->value());

        return $order;
    }
}
