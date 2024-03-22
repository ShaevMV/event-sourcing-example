<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\AddArrangementFee;

use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommand;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory\EsArrangementFeeRepositoryPersistence;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddArrangementFeeCommandHandlerTest extends KernelTestCase
{

    private EsArrangementFeeRepositoryPersistence $persistence;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        /** @var EsArrangementFeeRepositoryPersistence $persistence */
        $persistence = $kernel->getContainer()->get(EsArrangementFeeRepositoryPersistence::class);
        $this->persistence = $persistence;
    }

    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        /** @var AddArrangementFeeCommandHandler $handler */
        $handler = $kernel->getContainer()->get(AddArrangementFeeCommandHandler::class);
        $handlerResponse = $handler(new AddArrangementFeeCommand(
            'test',
            ArrangementId::random()->value(),
            1000
        ));
        $resultPersistence = $this->persistence->ofId(ArrangementId::fromString($handlerResponse->id));
        $id = ArrangementId::fromString($handlerResponse->id);
        self::assertTrue($id->equals(ArrangementId::fromString($resultPersistence->id()->value())));
    }
}