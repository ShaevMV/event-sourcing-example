<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalDelete;

use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\Festival\Model\FestivalRepositoryPersistence;
use Shared\Domain\Bus\Command\CommandHandler;

class FestivalDeleteCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FestivalRepositoryPersistence $festivalRepositoryPersistence,
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function __invoke(FestivalDeleteCommand $command): FestivalDeleteCommandResponse
    {
        $festival = $this->festivalRepositoryPersistence->ofId(FestivalId::fromString($command->id));
        $festival->delete();
        $this->festivalRepositoryPersistence->persist($festival);

        return new FestivalDeleteCommandResponse(
            true,
        );
    }
}
