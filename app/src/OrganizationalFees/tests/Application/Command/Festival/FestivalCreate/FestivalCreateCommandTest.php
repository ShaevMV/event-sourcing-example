<?php

namespace Tests\OrganizationalFees\Application\Command\Festival\FestivalCreate;

use OrganizationalFees\Application\Command\FestivalCreate\FestivalCreateCommand;
use OrganizationalFees\Application\Command\FestivalCreate\FestivalCreateCommandHandler;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Infrastructure\Repository\Domain\Festival\EventStory\EsFestivalRepositoryPersistence;
use Tests\OrganizationalFees\Infrastructure\Service\Template\BaseTemplateTestCase;

class FestivalCreateCommandTest extends BaseTemplateTestCase
{
    private EsFestivalRepositoryPersistence $persistence;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        /** @var EsFestivalRepositoryPersistence $persistence */
        $persistence = $kernel->getContainer()->get(EsFestivalRepositoryPersistence::class);
        $this->persistence = $persistence;
    }

    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        /** @var FestivalCreateCommandHandler $handler */
        $handler = $kernel->getContainer()->get(FestivalCreateCommandHandler::class);
        $handlerResponse = $handler(new FestivalCreateCommand(
            'test',
            new \DateTime(),
            (new \DateTime())->modify('+1 day'),
            $this->getFile(self::TEMPLATE_MAIL),
            $this->getFile(self::TEMPLATE_PDF),
        ));
        $resultPersistence = $this->persistence->ofId(FestivalId::fromString($handlerResponse->id));
        $id = FestivalId::fromString($handlerResponse->id);

        self::assertTrue($id->equals(FestivalId::fromString($resultPersistence->id()->value())));
    }
}