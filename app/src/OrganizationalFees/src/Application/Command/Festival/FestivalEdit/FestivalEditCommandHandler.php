<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalEdit;

use OrganizationalFees\Domain\Festival\Model\FestivalId;
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
            $command->name,
            new \DateTimeImmutable($command->dateStart),
            new \DateTimeImmutable($command->dateEnd),
            $command->pdfTemplate,
            $command->mailTemplate,
        );
        $this->festivalRepositoryPersistence->persist($festival);

        return new FestivalEditCommandResponse(
            true,
        );
    }
}
