<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetOrderList;

use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommand;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommandHandler;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQuery;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQueryHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Model\PromoCode;
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
            ArrangementId::random()->value(),
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