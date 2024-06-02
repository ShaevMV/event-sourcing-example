<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetOrderList;

use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommand;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandler;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommand;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommandHandler;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQuery;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQueryHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Infrastructure\Bus\Projection\Projector\Redis\ProjectorConsumer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommandTest;
use Tests\OrganizationalFees\Constant\TestConstant;
use Tests\OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeTest;

class GetOrderListQueryTest extends KernelTestCase
{
    private function createArrangement()
    {
        $kernel = self::bootKernel();
        /** @var AddArrangementFeeCommandHandler $handler */
        $handler = $kernel->getContainer()->get(AddArrangementFeeCommandHandler::class);
        $handlerResponse = $handler(new AddArrangementFeeCommand(
            'test',
            ArrangementId::random()->value(),
            1000
        ));
    }
    
    
    public function testGetListOrder(): void
    {
        $kernel = self::bootKernel();
        /** @var OrderCreateCommandHandler $handler */
        $handler = $kernel->getContainer()->get(OrderCreateCommandHandler::class);

        $handler(new OrderCreateCommand(
            ['test1', 'test2'],
            UserId::random()->value(),
            ArrangementId::random()->value(),
            TestConstant::FESTIVAL_ID,
            Title::fromString('test')->value()
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