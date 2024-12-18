<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\ArrangementFee\UpdatePrice;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementPrice;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementPriceTimestamp;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\ValueObject\ValidateException;

class UpdatePriceCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ArrangementFeeRepositoryPersistence $feeRepositoryDecoration,
    ) {
    }

    /**
     * @throws ValidateException
     */
    public function __invoke(UpdatePriceCommand $updatePriceCommand): void
    {
        $arrangement = $this->feeRepositoryDecoration->ofId(
            ArrangementId::fromString($updatePriceCommand->arrangementFeeId)
        );

        $this->feeRepositoryDecoration->persist(
            $arrangement->updatePrice(
                new ArrangementPrice($updatePriceCommand->price),
                new ArrangementPriceTimestamp($updatePriceCommand->timestamp)
            )
        );
    }
}
