<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\ArrangementFee\AddArrangementFee;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementName;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementPrice;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\ValueObject\ValidateException;

class AddArrangementFeeCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryPersistence $arrangementFeeRepositoryPersistence,
    ) {
    }

    /**
     * @throws ValidateException
     */
    public function __invoke(AddArrangementFeeCommand $addArrangementFeeCommand): AddArrangementFeeCommandResponse
    {
        $arrangementFee = ArrangementFee::create(
            ArrangementName::fromString($addArrangementFeeCommand->name),
            new ArrangementPrice($addArrangementFeeCommand->price),
            FestivalId::fromString($addArrangementFeeCommand->festivalId),
        );

        $this->arrangementFeeRepositoryPersistence->persist($arrangementFee);

        return new AddArrangementFeeCommandResponse($arrangementFee->id()->value());
    }
}
