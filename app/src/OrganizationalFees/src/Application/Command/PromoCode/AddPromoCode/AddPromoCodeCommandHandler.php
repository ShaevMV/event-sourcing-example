<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\PromoCode\AddPromoCode;

use OrganizationalFees\Domain\Festival\Model\FestivalId;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\Discount;
use OrganizationalFees\Domain\PromoCode\Model\Limit;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Model\Sing;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\ValueObject\ValidateException;

class AddPromoCodeCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly PromoCodeRepositoryPersistence $promoCodeRepositoryPersistence,
    ) {
    }

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     */
    public function __invoke(AddPromoCodeCommand $command): AddPromoCodeCommandHandlerResponse
    {
        $promoCode = PromoCode::create(
            Title::fromString($command->title),
            new Discount($command->discount),
            FestivalId::fromString($command->festivalId),
            Sing::fromString($command->sing),
            null === $command->limit ? null : new Limit($command->limit),
        );

        $this->promoCodeRepositoryPersistence->persist($promoCode);

        return new AddPromoCodeCommandHandlerResponse($promoCode->id()->value());
    }
}
