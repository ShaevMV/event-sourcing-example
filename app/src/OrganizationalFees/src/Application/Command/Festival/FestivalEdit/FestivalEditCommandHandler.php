<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalEdit;

use OrganizationalFees\Domain\Festival\Model\FestivalDateEndImmutable;
use OrganizationalFees\Domain\Festival\Model\FestivalDateStartImmutable;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\Festival\Model\FestivalMailTemplate;
use OrganizationalFees\Domain\Festival\Model\FestivalName;
use OrganizationalFees\Domain\Festival\Model\FestivalPdfTemplate;
use OrganizationalFees\Domain\Festival\Model\FestivalRepositoryPersistence;
use Shared\Domain\Bus\Command\CommandHandler;

class FestivalEditCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FestivalRepositoryPersistence $festivalRepositoryPersistence,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function __invoke(FestivalEditCommand $command): FestivalEditCommandResponse
    {
        $festival = $this->festivalRepositoryPersistence->ofId(FestivalId::fromString($command->id));
        $festival->edit(
            FestivalName::fromString($command->name),
            new FestivalDateStartImmutable(new \DateTimeImmutable($command->dateStart)),
            new FestivalDateEndImmutable(new \DateTimeImmutable($command->dateEnd)),
            FestivalPdfTemplate::fromString($command->pdfTemplate),
            FestivalMailTemplate::fromString($command->mailTemplate),
        );
        $this->festivalRepositoryPersistence->persist($festival);

        return new FestivalEditCommandResponse(
            true,
        );
    }
}
