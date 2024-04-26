<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetOrderList;

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
use Tests\OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeTest;

class GetOrderListQueryTest extends KernelTestCase
{

    private ArrangementFee $arrangementFee;

    protected function setUp(): void
    {
        parent::setUp();


        $kernel = self::bootKernel();

        /** @var OrderCreateCommandTest $OrderCreateCommandTest */
        $arrangementFee = $kernel->getContainer()->get(OrderCreateCommandTest::class);
        $this->arrangementFee = $arrangementFee->testCreate();
    }

    public function testGetListOrder():void
    {
        $kernel = self::bootKernel();



        /** @var OrderCreateCommandHandler $handler */
        $handler = $kernel->getContainer()->get(OrderCreateCommandHandler::class);

        $handler(new OrderCreateCommand(
            ['test1','test2'],
            $this->arrangementFee->id()->value(),
            UserId::random()->value(),
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