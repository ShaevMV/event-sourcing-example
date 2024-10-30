<?php

namespace Tests\OrganizationalFees\Application\Command\UpdatePrice;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\UpdatePrice\UpdatePriceCommand;
use OrganizationalFees\Application\Command\UpdatePrice\UpdatePriceCommandHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory\EsArrangementFeeRepositoryPersistence;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandlerTest;

class UpdatePriceCommandHandlerTest extends InfrastructureTestCase
{
    use ReadModelTrait;

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testCreate(): void
    {
        /** @var EsArrangementFeeRepositoryPersistence $persistence */
        $persistence = $this->get(EsArrangementFeeRepositoryPersistence::class);

        /** @var AddArrangementFeeCommandHandlerTest $arrangementFeeTest */
        $arrangementFeeTest = $this->get(AddArrangementFeeCommandHandlerTest::class);
        $arrangementFee = $arrangementFeeTest->testCreate();

        /** @var UpdatePriceCommandHandler $handler */
        $handler = $this->get(UpdatePriceCommandHandler::class);
        $handler(new UpdatePriceCommand(
            $arrangementFee->id()->value(),
            1100,
            time()
        ));
        $resultPersistence = $persistence->ofId(ArrangementId::fromString($arrangementFee->id()->value()));

        self::assertEquals(1100, $resultPersistence->getPrice());

        $this->consumer();

        $result = $this->getReadModel('arrangement_fee', $arrangementFee->id()->value());
        self::assertEquals(1100, $result['price']);
    }
}
