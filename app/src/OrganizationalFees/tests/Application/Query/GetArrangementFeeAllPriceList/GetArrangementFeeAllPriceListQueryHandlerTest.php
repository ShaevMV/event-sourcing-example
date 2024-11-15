<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetArrangementFeeAllPriceList;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeAllPriceList\GetArrangementFeeAllPriceListQuery;
use OrganizationalFees\Application\Query\ArrangementFee\GetArrangementFeeAllPriceList\GetArrangementFeeAllPriceListQueryHandler;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Tests\OrganizationalFees\Application\Command\ArrangementFee\UpdatePrice\UpdatePriceCommandHandlerTest;
use Tests\OrganizationalFees\Constant\TestConstant;

class GetArrangementFeeAllPriceListQueryHandlerTest extends InfrastructureTestCase
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testGetArrangementFeeList(): void
    {
        /** @var UpdatePriceCommandHandlerTest $updatePriceCommandHandlerTest */
        $updatePriceCommandHandlerTest = $this->get(UpdatePriceCommandHandlerTest::class);
        $updatePriceCommandHandlerTest->testCreate();

        /** @var GetArrangementFeeAllPriceListQueryHandler $handler */
        $handler = $this->get(GetArrangementFeeAllPriceListQueryHandler::class);
        $result = $handler(new GetArrangementFeeAllPriceListQuery(
            TestConstant::FESTIVAL_ID
        ));

        self::assertNotEmpty($result->arrangementFees);
        self::assertCount(2, $result->arrangementFees);
    }
}
