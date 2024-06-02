<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\Festival\FestivalCreate;

use OrganizationalFees\Application\Service\Template\TemplateServiceInterface;
use OrganizationalFees\Domain\Festival\Model\Festival;
use OrganizationalFees\Domain\Festival\Model\FestivalRepositoryPersistence;
use Shared\Domain\Bus\Command\CommandHandler;

class FestivalCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly FestivalRepositoryPersistence $festivalRepositoryPersistence,
        private readonly TemplateServiceInterface $templateService,
    )
    {
    }

    public function __invoke(FestivalCreateCommand $command): FestivalCreateCommandResponse
    {
        $festival = Festival::create(
            $command->name,
            $command->dateStart,
            $command->dateEnd,
            $this->templateService->save($command->pdfTemplate),
            $this->templateService->save($command->mailTemplate),
        );

        $this->festivalRepositoryPersistence->persist($festival);

        return new FestivalCreateCommandResponse($festival->id()->value());
    }
}