<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\ArrangementFee\UpdatePrice;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use Shared\Domain\Bus\Command\CommandHandler;

class UpdatePriceCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryPersistence $feeRepositoryDecoration,
    ) {
    }

    public function __invoke(UpdatePriceCommand $updatePriceCommand): void
    {
        $arrangement = $this->feeRepositoryDecoration->ofId(
            ArrangementId::fromString($updatePriceCommand->arrangementFeeId)
        );

        $this->feeRepositoryDecoration->persist(
            $arrangement->updatePrice($updatePriceCommand->price, $updatePriceCommand->timestamp)
        );
    }
}
