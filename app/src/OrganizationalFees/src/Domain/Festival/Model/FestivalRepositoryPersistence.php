<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Festival\Model;

interface FestivalRepositoryPersistence
{
    public function ofId(FestivalId $aggregateId): Festival;

    public function persist(Festival $festival): void;
}
