<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\Order\OrderApproved;

use Auth\Domain\User\Model\UserId;
use Doctrine\DBAL\Exception;
use OrganizationalFees\Application\Command\Order\OrderApproved\OrderApprovedCommand;
use OrganizationalFees\Application\Command\Order\OrderApproved\OrderApprovedCommandHandler;
use OrganizationalFees\Domain\Order\Model\OrderId;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use Shared\Domain\ValueObject\Status;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Application\Command\Order\OrderCreate\OrderCreateCommandTest;

class OrderApprovedCommandTest extends InfrastructureTestCase
{
    use ReadModelTrait;

    /**
     * @throws ValidateException
     * @throws Exception
     * @throws PromoCodeSingDontCorrectException
     * @throws \Exception
     */
    public function testApproved(): void
    {
        /** @var OrderCreateCommandTest $orderCreateCommandTest */
        $orderCreateCommandTest = $this->get(OrderCreateCommandTest::class);
        $orderOld = $orderCreateCommandTest->testCreate();

        /** @var OrderApprovedCommandHandler $handler */
        $handler = $this->get(OrderApprovedCommandHandler::class);
        $userId = UserId::random()->value();
        $orderResponse = $handler(new OrderApprovedCommand($orderOld->id()->value(), $userId));
        self::assertTrue($orderResponse->success);
        /** @var OrderRepositoryPersistence $orderRepositoryPersistence */
        $orderRepositoryPersistence = $this->get(OrderRepositoryPersistence::class);
        $order = $orderRepositoryPersistence->ofId(OrderId::fromString($orderOld->id()->value()));

        self::assertEquals(Status::APPROVED, $order->getStatus()->status->value());
        self::assertEquals($userId, $order->getStatus()->userModified->value());
        self::assertNotEquals($orderOld->getStatus()->userModified->value(), $order->getStatus()->userModified->value());

        $orderArr = $this->getReadModel('"order"', $order->id()->value());

        self::assertEquals(Status::APPROVED, $orderArr['status']);

        $orderResponse = $handler(new OrderApprovedCommand($orderOld->id()->value(), $userId));
        self::assertFalse($orderResponse->success);
        self::assertNotEmpty($orderResponse->message);
    }
}
