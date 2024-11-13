<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetArrangementFeeList;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeList\GetArrangementFeeListQuery;
use OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeList\GetArrangementFeeListQueryHandler;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Tests\OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandlerTest;
use Tests\OrganizationalFees\Constant\TestConstant;

class GetArrangementFeeListQueryHandlerTest extends InfrastructureTestCase
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testGetArrangementFeeList(): void
    {
        /** @var AddArrangementFeeCommandHandlerTest $addArrangementFeeCommandHandlerTest */
        $addArrangementFeeCommandHandlerTest = $this->get(AddArrangementFeeCommandHandlerTest::class);
        $addArrangementFeeCommandHandlerTest->testCreate();

        /** @var GetArrangementFeeListQueryHandler $handler */
        $handler = $this->get(GetArrangementFeeListQueryHandler::class);
        $result = $handler(new GetArrangementFeeListQuery(
            TestConstant::FESTIVAL_ID
        ));

        self::assertNotEmpty($result->arrangementFees);
    }
}
