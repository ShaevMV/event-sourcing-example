<?php

declare(strict_types=1);

namespace Tests\ArrangementFee\Application\Query\GetOrderList;

use ArrangementFee\Application\Query\GetOrderList\GetOrderListQuery;
use ArrangementFee\Application\Query\GetOrderList\GetOrderListQueryHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetOrderListQueryTest extends KernelTestCase
{
    public function testGetListOrder():void
    {
        $kernel = self::bootKernel();
        /** @var  GetOrderListQueryHandler $handler */
        $handler = $kernel->getContainer()->get(GetOrderListQueryHandler::class);

        $result = $handler(new GetOrderListQuery());

        $this->assertNotEmpty($result->orderList);
    }
}