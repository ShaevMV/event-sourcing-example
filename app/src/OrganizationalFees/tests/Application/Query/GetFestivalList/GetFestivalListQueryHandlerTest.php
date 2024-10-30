<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\GetFestivalList;

use OrganizationalFees\Application\Query\GetFestivalList\GetFestivalListQuery;
use OrganizationalFees\Application\Query\GetFestivalList\GetFestivalListQueryHandler;
use Tests\OrganizationalFees\Application\Command\Festival\FestivalCreateCommandTest;
use Tests\OrganizationalFees\Infrastructure\Service\Template\BaseTemplateTestCase;

class GetFestivalListQueryHandlerTest extends BaseTemplateTestCase
{
    /**
     * @throws \Exception
     */
    public function testGetFestivalLIst(): void
    {
        /** @var FestivalCreateCommandTest $festivalCreateCommandTest */
        $festivalCreateCommandTest = $this->get(FestivalCreateCommandTest::class);
        $festivalCreateCommandTest->testCreate();

        /** @var GetFestivalListQueryHandler $handler */
        $handler = $this->get(GetFestivalListQueryHandler::class);
        $festivalList = $handler(new GetFestivalListQuery());
        self::assertNotEmpty($festivalList);
    }
}
