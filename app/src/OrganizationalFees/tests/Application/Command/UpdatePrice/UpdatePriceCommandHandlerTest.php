<?php

namespace Tests\OrganizationalFees\Application\Command\UpdatePrice;

use OrganizationalFees\Application\Command\UpdatePrice\UpdatePriceCommand;
use OrganizationalFees\Application\Command\UpdatePrice\UpdatePriceCommandHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory\EsArrangementFeeRepositoryPersistence;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Tests\OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandlerTest;
use Tests\OrganizationalFees\BaseKernelTestCase;

class UpdatePriceCommandHandlerTest extends InfrastructureTestCase
{
    private EsArrangementFeeRepositoryPersistence $persistence;
    private ArrangementFee $arrangementFee;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        /** @var EsArrangementFeeRepositoryPersistence $persistence */
        $persistence = $kernel->getContainer()->get(EsArrangementFeeRepositoryPersistence::class);
        $this->persistence = $persistence;

        /** @var AddArrangementFeeCommandHandlerTest $arrangementFee */
        $arrangementFee = $kernel->getContainer()->get(AddArrangementFeeCommandHandlerTest::class);
        $this->arrangementFee = $arrangementFee->testCreate();
    }

    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        /** @var UpdatePriceCommandHandler $handler */
        $handler = $kernel->getContainer()->get(UpdatePriceCommandHandler::class);
        $handler(new UpdatePriceCommand(
            $this->arrangementFee->id()->value(),
            1100,
            time()
        ));
        $resultPersistence = $this->persistence->ofId(ArrangementId::fromString($this->arrangementFee->id()->value()));

        self::assertEquals(1100, $resultPersistence->getPrice());
    }
}
