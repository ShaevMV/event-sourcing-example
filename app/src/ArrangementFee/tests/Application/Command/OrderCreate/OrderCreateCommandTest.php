<?php

declare(strict_types=1);

namespace Tests\ArrangementFee\Application\Command\OrderCreate;

use ArrangementFee\Application\Command\OrderCreate\OrderCreateCommand;
use ArrangementFee\Application\Command\OrderCreate\OrderCreateCommandHandler;
use ArrangementFee\Domain\ArrangementFee\Model\ArrangementTypeId;
use ArrangementFee\Domain\Order\Model\OrderId;
use ArrangementFee\Domain\Order\Model\OrderRepositoryPersistence;
use ArrangementFee\Domain\Order\Model\PromoCode;
use ArrangementFee\Infrastructure\Repository\Domain\Order\EventStore\EsOrderRepositoryPersistence;
use Auth\Domain\User\Model\UserId;
use Shared\Infrastructure\Bus\Projection\Projector\Redis\ProjectorConsumer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderCreateCommandTest extends KernelTestCase
{
    private OrderRepositoryPersistence $orderRepositoryPersistence;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        /** @var OrderRepositoryPersistence $orderRepositoryPersistence */
        $orderRepositoryPersistence = $kernel->getContainer()->get(EsOrderRepositoryPersistence::class);
        $this->orderRepositoryPersistence = $orderRepositoryPersistence;
    }

    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        /** @var  OrderCreateCommandHandler $handler */
        $handler = $kernel->getContainer()->get(OrderCreateCommandHandler::class);

        $orderResponse = $handler(new OrderCreateCommand(
            ['test1','test2'],
            ArrangementTypeId::random()->value(),
            UserId::random()->value(),
            PromoCode::fromString('')->value()
        ));

        $orderId = OrderId::fromString($orderResponse->orderId);
        $order = $this->orderRepositoryPersistence->ofId(OrderId::fromString($orderResponse->orderId));
        self::assertTrue($orderId->equals(OrderId::fromString($order->id()->value())));
        /** @var ProjectorConsumer $workerProjectionRedis */
        $workerProjectionRedis = $kernel->getContainer()->get(ProjectorConsumer::class);
        $workerProjectionRedis->consume();


    }
}