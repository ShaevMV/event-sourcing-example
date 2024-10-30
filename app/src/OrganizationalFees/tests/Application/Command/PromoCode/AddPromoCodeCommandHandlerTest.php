<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\PromoCode;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommand;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommandHandler;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Infrastructure\Repository\Domain\PromoCode\EventStory\EsPromoCodeRepositoryPersistence;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Constant\TestConstant;

class AddPromoCodeCommandHandlerTest extends InfrastructureTestCase
{
    use ReadModelTrait;
    public const DISCOUNT = 100;
    public const TITLE = 'test';

    private EsPromoCodeRepositoryPersistence $persistence;

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     * @throws Exception
     * @throws \Exception
     */
    public function testCreate(): PromoCode
    {
        /** @var AddPromoCodeCommandHandler $handler */
        $handler = $this->get(AddPromoCodeCommandHandler::class);
        $handlerResponse = $handler(new AddPromoCodeCommand(
            'test',
            self::DISCOUNT,
            TestConstant::FESTIVAL_ID,
            '%',
            100,
        ));
        /** @var EsPromoCodeRepositoryPersistence $persistence */
        $persistence = $this->get(EsPromoCodeRepositoryPersistence::class);
        $resultPersistence = $persistence->ofId(PromoCodeId::fromString($handlerResponse->id));

        $id = PromoCodeId::fromString($handlerResponse->id);
        self::assertTrue($id->equals(PromoCodeId::fromString($resultPersistence->id()->value())));
        $this->consumer();

        self::assertNotEmpty($this->getReadModel('promo_code', $id->value()));

        return $resultPersistence;
    }
}
