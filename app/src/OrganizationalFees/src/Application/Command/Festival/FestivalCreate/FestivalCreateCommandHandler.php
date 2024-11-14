<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalCreate;

use OrganizationalFees\Domain\Festival\Model\Festival;
use OrganizationalFees\Domain\Festival\Model\FestivalDateEndImmutable;
use OrganizationalFees\Domain\Festival\Model\FestivalDateStartImmutable;
use OrganizationalFees\Domain\Festival\Model\FestivalMailTemplate;
use OrganizationalFees\Domain\Festival\Model\FestivalName;
use OrganizationalFees\Domain\Festival\Model\FestivalPdfTemplate;
use OrganizationalFees\Domain\Festival\Model\FestivalRepositoryPersistence;
use Shared\Domain\Bus\Command\CommandHandler;

class FestivalCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FestivalRepositoryPersistence $festivalRepositoryPersistence,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function __invoke(FestivalCreateCommand $command): FestivalCreateCommandResponse
    {
        $festival = Festival::create(
            FestivalName::fromString($command->name),
            new FestivalDateStartImmutable(new \DateTimeImmutable($command->dateStart)),
            new FestivalDateEndImmutable(new \DateTimeImmutable($command->dateEnd)),
            FestivalPdfTemplate::fromString($command->pdfTemplate),
            FestivalMailTemplate::fromString($command->mailTemplate),
        );

        $this->festivalRepositoryPersistence->persist($festival);

        return new FestivalCreateCommandResponse($festival->id()->value());
    }
}
