<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\Festival;

use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\FestivalCreate\FestivalCreateCommand;
use OrganizationalFees\Application\Command\FestivalCreate\FestivalCreateCommandHandler;
use OrganizationalFees\Domain\Festival\Model\Festival;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Infrastructure\Repository\Domain\Festival\EventStory\EsFestivalRepositoryPersistence;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Infrastructure\Service\Template\BaseTemplateTestCase;

class FestivalCreateCommandTest extends BaseTemplateTestCase
{
    use ReadModelTrait;

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testCreate(): Festival
    {
        /** @var EsFestivalRepositoryPersistence $persistence */
        $persistence = $this->get(EsFestivalRepositoryPersistence::class);
        /** @var FestivalCreateCommandHandler $handler */
        $handler = $this->get(FestivalCreateCommandHandler::class);
        $handlerResponse = $handler(new FestivalCreateCommand(
            'test',
            (new \DateTimeImmutable())->format('Y-m-d'),
            ((new \DateTimeImmutable())->modify('+1 day'))->format('Y-m-d'),
            $this->getFile(self::TEMPLATE_MAIL)->getContent(),
            $this->getFile(self::TEMPLATE_PDF)->getContent(),
        ));
        $resultPersistence = $persistence->ofId(FestivalId::fromString($handlerResponse->id));
        $id = FestivalId::fromString($handlerResponse->id);
        self::assertTrue($id->equals(FestivalId::fromString($resultPersistence->id()->value())));

        $this->consumer();

        $rearModelResult = $this->getReadModel('festival', $id->value());
        self::assertNotEmpty($rearModelResult);

        return $resultPersistence;
    }
}
