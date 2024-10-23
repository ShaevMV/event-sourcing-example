<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\AddArrangementFee;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\Model\FestivalId;

class AddArrangementFeeCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryPersistence $arrangementFeeRepositoryPersistence
    ) {
    }

    public function __invoke(AddArrangementFeeCommand $addArrangementFeeCommand): AddArrangementFeeCommandResponse
    {
        $arrangementFee = ArrangementFee::create(
            $addArrangementFeeCommand->name,
            $addArrangementFeeCommand->price,
            FestivalId::fromString($addArrangementFeeCommand->festivalId),
        );

        $this->arrangementFeeRepositoryPersistence->persist($arrangementFee);

        return new AddArrangementFeeCommandResponse($arrangementFee->id()->value());
    }
}
