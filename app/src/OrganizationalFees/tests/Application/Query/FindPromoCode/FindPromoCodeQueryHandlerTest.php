<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Query\FindPromoCode;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Query\FindPromoCode\FindPromoCodeQuery;
use OrganizationalFees\Application\Query\FindPromoCode\FindPromoCodeQueryHandler;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Tests\OrganizationalFees\Application\Command\PromoCode\AddPromoCodeCommandHandlerTest;
use Tests\OrganizationalFees\Constant\TestConstant;

class FindPromoCodeQueryHandlerTest extends InfrastructureTestCase
{
    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     * @throws Exception
     * @throws \Exception
     */
    public function testFindPromoCode(): void
    {
        /** @var AddPromoCodeCommandHandlerTest $addPromoCodeCommandHandlerTest */
        $addPromoCodeCommandHandlerTest = $this->get(AddPromoCodeCommandHandlerTest::class);
        $promoCode = $addPromoCodeCommandHandlerTest->testCreate();

        /** @var FindPromoCodeQueryHandler $findPromoCodeQueryHandler */
        $findPromoCodeQueryHandler = $this->get(FindPromoCodeQueryHandler::class);
        $result = $findPromoCodeQueryHandler(new FindPromoCodeQuery(
            $promoCode->getTitle()->value(),
            TestConstant::FESTIVAL_ID,
        ));

        self::assertNotEmpty($result);
        self::assertEquals(AddPromoCodeCommandHandlerTest::DISCOUNT, $result->discount);
    }
}
