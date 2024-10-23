<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\PromoCode;

use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommand;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommandHandler;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Infrastructure\Repository\Domain\PromoCode\EventStory\EsPromoCodeRepositoryPersistence;
use Shared\Domain\Model\FestivalId;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Bus\Projection\Projector\Redis\ProjectorConsumer;
use Tests\OrganizationalFees\BaseKernelTestCase;

class AddPromoCodeCommandHandlerTest extends BaseKernelTestCase
{
    private EsPromoCodeRepositoryPersistence $persistence;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        /** @var EsPromoCodeRepositoryPersistence $persistence */
        $persistence = $kernel->getContainer()->get(EsPromoCodeRepositoryPersistence::class);
        $this->persistence = $persistence;
    }

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     */
    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        /** @var AddPromoCodeCommandHandler $handler */
        $handler = $kernel->getContainer()->get(AddPromoCodeCommandHandler::class);
        $handlerResponse = $handler(new AddPromoCodeCommand(
            'test',
            100,
            FestivalId::random()->value(),
            '%',
            100,
        ));
        $resultPersistence = $this->persistence->ofId(PromoCodeId::fromString($handlerResponse->id));
        $id = PromoCodeId::fromString($handlerResponse->id);
        /** @var ProjectorConsumer $consumer */
        $consumer = $kernel->getContainer()->get(ProjectorConsumer::class);
        $consumer->consume();

        self::assertTrue($id->equals(PromoCodeId::fromString($resultPersistence->id()->value())));
    }
}