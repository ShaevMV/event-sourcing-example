<?php

declare(strict_types=1);

namespace OrganizationalFees\Application\Command\OrderApproved;

use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Domain\Order\Model\OrderId;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use Shared\Domain\Bus\Command\CommandHandler;

class OrderApprovedCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly OrderRepositoryPersistence $orderRepositoryPersistence,
    ) {
    }

    public function __invoke(OrderApprovedCommand $orderApprovedCommand): OrderApprovedCommandResponse
    {
        $order = $this->orderRepositoryPersistence->ofId(OrderId::fromString($orderApprovedCommand->orderId));
        try {
            $order->approved(UserId::fromString($orderApprovedCommand->userId));
            $this->orderRepositoryPersistence->persist($order);

            return new OrderApprovedCommandResponse(
                true
            );
        } catch (\DomainException $errorDomainException) {
            return new OrderApprovedCommandResponse(
                false,
                $errorDomainException->getMessage()
            );
        }
    }
}
