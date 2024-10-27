<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\AddArrangementFee;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommand;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory\EsArrangementFeeRepositoryPersistence;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;

class AddArrangementFeeCommandHandlerTest extends InfrastructureTestCase
{
    use ReadModelTrait;

    /**
     * @throws Exception
     */
    public function testCreate(): ArrangementFee
    {
        /** @var EsArrangementFeeRepositoryPersistence $persistence */
        $persistence = $this->get(EsArrangementFeeRepositoryPersistence::class);

        /** @var AddArrangementFeeCommandHandler $handler */
        $handler = $this->get(AddArrangementFeeCommandHandler::class);
        $handlerResponse = $handler(new AddArrangementFeeCommand(
            'test',
            ArrangementId::random()->value(),
            1000
        ));
        $resultPersistence = $persistence->ofId(ArrangementId::fromString($handlerResponse->id));
        $id = ArrangementId::fromString($handlerResponse->id);
        self::assertTrue($id->equals(ArrangementId::fromString($resultPersistence->id()->value())));
        $this->consumer();

        self::assertNotEmpty($this->getReadModel('arrangement_fee', $id->value()));

        return $resultPersistence;
    }
}
