<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\ArrangementFee\AddArrangementFee;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use Shared\Domain\Bus\Command\CommandHandler;


class AddArrangementFeeCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryPersistence $arrangementFeeRepositoryPersistence,
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
