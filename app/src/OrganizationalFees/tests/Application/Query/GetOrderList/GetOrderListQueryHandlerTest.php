<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetOrderList;

use App\DataFixtures\UserFixture;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQuery;
use OrganizationalFees\Application\Query\GetOrderList\GetOrderListQueryHandler;
use Shared\Domain\ValueObject\Status;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Tests\OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommandTest;
use Tests\OrganizationalFees\Application\Command\PromoCode\AddPromoCodeCommandHandlerTest;
use Tests\OrganizationalFees\Constant\TestConstant;

class GetOrderListQueryHandlerTest extends InfrastructureTestCase
{
    /**
     * @throws \Exception
     */
    public function testGetOrderList(): void
    {
        /** @var OrderCreateCommandTest $orderCreateCommandTest */
        $orderCreateCommandTest = $this->get(OrderCreateCommandTest::class);
        $orderCreateCommandTest->testCreate();

        /** @var GetOrderListQueryHandler $handler */
        $handler = $this->get(GetOrderListQueryHandler::class);
        $result = $handler(new GetOrderListQuery(
            TestConstant::FESTIVAL_ID,
            UserFixture::USER_EMAIL,
            Status::NEW,
            1000,
            AddPromoCodeCommandHandlerTest::TITLE
        ));

        self::assertNotEmpty($result);
    }
}
