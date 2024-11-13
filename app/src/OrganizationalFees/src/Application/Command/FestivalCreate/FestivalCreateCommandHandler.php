<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\FestivalCreate;

use OrganizationalFees\Domain\Festival\Model\Festival;
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
            $command->name,
            new \DateTimeImmutable($command->dateStart),
            new \DateTimeImmutable($command->dateEnd),
            $command->pdfTemplate,
            $command->mailTemplate,
        );

        $this->festivalRepositoryPersistence->persist($festival);

        return new FestivalCreateCommandResponse($festival->id()->value());
    }
}
