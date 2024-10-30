<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\FindActiveFestival;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Query\FindActiveFestival\FindActiveFestivalQuery;
use OrganizationalFees\Application\Query\FindActiveFestival\FindActiveFestivalQueryHandler;
use Tests\OrganizationalFees\Application\Command\Festival\FestivalCreateCommandTest;
use Tests\OrganizationalFees\Infrastructure\Service\Template\BaseTemplateTestCase;

class FindActiveFestivalQueryHandlerTest extends BaseTemplateTestCase
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testFind(): void
    {
        /** @var FestivalCreateCommandTest $festivalCreateCommandTest */
        $festivalCreateCommandTest = $this->get(FestivalCreateCommandTest::class);
        $festivalCreateCommandTest->testCreate();

        /** @var FindActiveFestivalQueryHandler $handler */
        $handler = $this->get(FindActiveFestivalQueryHandler::class);
        $festival = $handler(new FindActiveFestivalQuery(
            (new \DateTime('now'))->format('Y-m-d H:i:s'),
        ));
        self::assertNotEmpty($festival->festival);
    }
}
