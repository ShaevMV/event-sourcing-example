<?php

declare(strict_types=1);

namespace ExportService\Domain\Application\Model;

use ExportService\Domain\Application\Event\ApplicationCreated;
use ExportService\Domain\Application\Model\ApplicationDTO\ApplicationDTO;
use ExportService\Domain\Application\Model\ClientDTO\ClientDTO;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

final class Application extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    protected ApplicationDTO $applicationDTO;
    protected ClientDTO $clientDTO;

    public static function applicationCreated(
        ApplicationId  $applicationId,
        ClientDTO      $clientDTO,
        ApplicationDTO $applicationDTO
    ): self
    {
        $application = new self($applicationId);
        $application->recordAndApply(new ApplicationCreated(
            $applicationId->value(),
            $clientDTO,
            $applicationDTO
        ));

        return $application;
    }

    public function onApplicationCreated(ApplicationCreated $applicationCreated): void
    {
        $this->id = ApplicationId::fromString($applicationCreated->getAggregateId());
        $this->applicationDTO = $applicationCreated->applicationDTO;
        $this->clientDTO = $applicationCreated->clientDTO;
    }
}