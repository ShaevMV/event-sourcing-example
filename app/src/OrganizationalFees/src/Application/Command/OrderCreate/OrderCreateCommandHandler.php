<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\OrderCreate;

use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Application\Model\PromoCodeRepositoryInterface;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFeeRepositoryPersistence;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Model\Order;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use Shared\Domain\Bus\Command\CommandHandler;
use Shared\Domain\Model\FestivalId;

class OrderCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly OrderRepositoryPersistence $orderRepositoryPersistence,
        private readonly ArrangementFeeRepositoryPersistence $feeRepositoryDecoration,
        private readonly PromoCodeRepositoryInterface $promoCodeRepository,
        private readonly PromoCodeRepositoryPersistence $promoCodeRepositoryPersistence,
    ) {
    }

    public function __invoke(OrderCreateCommand $orderCreateCommand): OrderCreateCommandResponse
    {
        $arrangementFee = $this->feeRepositoryDecoration->ofId(
            ArrangementId::fromString($orderCreateCommand->arrangementFeeId)
        );
        $promoCode = $this->getAndPersistPromoCode($orderCreateCommand->promoCode, $orderCreateCommand->festivalId);
        $order = Order::create(
            $orderCreateCommand->guestNames,
            $arrangementFee,
            UserId::fromString($orderCreateCommand->userId),
            $promoCode,
        );
        $this->orderRepositoryPersistence->persist($order);

        return new OrderCreateCommandResponse($order->id()->value());
    }

    private function getAndPersistPromoCode(?string $promoCodeTitle, string $festivalId): ?PromoCode
    {
        if (null === $promoCodeTitle) {
            return null;
        }

        $promoCodeId = $this->promoCodeRepository->findPromoCode(
            Title::fromString($promoCodeTitle),
            FestivalId::fromString($festivalId)
        )?->id;

        if (null === $promoCodeId) {
            return null;
        }

        $promoCode = $this->promoCodeRepositoryPersistence->ofId(PromoCodeId::fromString($promoCodeId))
            ->applyPromoCode();

        $this->promoCodeRepositoryPersistence->persist($promoCode);

        return $promoCode;
    }
}
