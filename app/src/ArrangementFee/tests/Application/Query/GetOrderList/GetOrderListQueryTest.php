<?php

declare(strict_types=1);

namespace Tests\ArrangementFee\Application\Query\GetOrderList;

use ArrangementFee\Application\Command\OrderCreate\OrderCreateCommand;
use ArrangementFee\Application\Command\OrderCreate\OrderCreateCommandHandler;
use ArrangementFee\Application\Query\GetOrderList\GetOrderListQuery;
use ArrangementFee\Application\Query\GetOrderList\GetOrderListQueryHandler;
use ArrangementFee\Domain\ArrangementFee\Model\ArrangementTypeId;
use ArrangementFee\Domain\Order\Model\PromoCode;
use Auth\Domain\User\Model\UserId;
use Shared\Infrastructure\Bus\Projection\Projector\Redis\ProjectorConsumer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetOrderListQueryTest extends KernelTestCase
{
    public function testGetListOrder():void
    {
        $kernel = self::bootKernel();
        /** @var OrderCreateCommandHandler $handler */
        $handler = $kernel->getContainer()->get(OrderCreateCommandHandler::class);

        $handler(new OrderCreateCommand(
            ['test1','test2'],
            ArrangementTypeId::random()->value(),
            UserId::random()->value(),
            PromoCode::fromString('')->value()
        ));

        /** @var ProjectorConsumer $workerProjectionRedis */
        $workerProjectionRedis = $kernel->getContainer()->get(ProjectorConsumer::class);
        $workerProjectionRedis->consume();

        /** @var  GetOrderListQueryHandler $handler */
        $handler = $kernel->getContainer()->get(GetOrderListQueryHandler::class);

        $result = $handler(new GetOrderListQuery());

        $this->assertNotEmpty($result->orderList);
    }
}