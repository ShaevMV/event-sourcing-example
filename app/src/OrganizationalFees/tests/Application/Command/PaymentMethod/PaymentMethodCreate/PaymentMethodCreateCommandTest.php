<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\PaymentMethod\PaymentMethodCreate;

use OrganizationalFees\Application\Command\PaymentMethod\PaymentMethodCreate\PaymentMethodCreateCommand;
use OrganizationalFees\Application\Command\PaymentMethod\PaymentMethodCreate\PaymentMethodCreateCommandHandler;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodId;
use OrganizationalFees\Domain\PaymentMethod\Model\PaymentMethodPersistence;
use Shared\Infrastructure\Tests\PhpUnit\InfrastructureTestCase;
use Shared\Infrastructure\Tests\PhpUnit\ReadModelTrait;
use Tests\OrganizationalFees\Constant\TestConstant;

class PaymentMethodCreateCommandTest extends InfrastructureTestCase
{
    use ReadModelTrait;

    /**
     * @throws \Exception
     */
    public function testCreate(): void
    {
        /** @var PaymentMethodCreateCommandHandler $handler */
        $handler = $this->get(PaymentMethodCreateCommandHandler::class);
        $response = $handler(new PaymentMethodCreateCommand(
            'test1',
            TestConstant::FESTIVAL_ID,
            true,
            1,
        ));
        $paymentMethodId = PaymentMethodId::fromString($response->id);
        /** @var PaymentMethodPersistence $paymentMethodPersistence */
        $paymentMethodPersistence = $this->get(PaymentMethodPersistence::class);
        $paymentMethod = $paymentMethodPersistence->ofId($paymentMethodId);

        self::assertTrue($paymentMethod->id()->equals($paymentMethodId));

        $paymentMethodRead = $this->getReadModel('payment_method', $paymentMethodId->value());

        self::assertEquals(
            $paymentMethodRead['id'],
            $paymentMethodId->value()
        );
    }
}
