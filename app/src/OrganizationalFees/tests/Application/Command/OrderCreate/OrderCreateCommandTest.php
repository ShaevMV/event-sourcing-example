<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Application\Command\OrderCreate;

use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommand;
use OrganizationalFees\Application\Command\AddArrangementFee\AddArrangementFeeCommandHandler;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommand;
use OrganizationalFees\Application\Command\AddPromoCode\AddPromoCodeCommandHandler;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommand;
use OrganizationalFees\Application\Command\OrderCreate\OrderCreateCommandHandler;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Order\Model\OrderId;
use OrganizationalFees\Domain\Order\Model\OrderRepositoryPersistence;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeId;
use OrganizationalFees\Infrastructure\Repository\Domain\ArrangementFee\EventStory\EsArrangementFeeRepositoryPersistence;
use OrganizationalFees\Infrastructure\Repository\Domain\Order\EventStore\EsOrderRepositoryPersistence;
use Auth\Domain\User\Model\UserId;
use OrganizationalFees\Infrastructure\Repository\Domain\PromoCode\EventStory\EsPromoCodeRepositoryPersistence;
use Shared\Domain\Model\FestivalId;
use Shared\Domain\ValueObject\ValidateException;
use Shared\Infrastructure\Bus\Projection\Projector\Redis\ProjectorConsumer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\OrganizationalFees\Constant\TestConstant;

class OrderCreateCommandTest extends KernelTestCase
{
    private OrderRepositoryPersistence $orderRepositoryPersistence;
    private EsArrangementFeeRepositoryPersistence $arrangementFeeRepositoryPersistence;
    private EsPromoCodeRepositoryPersistence $promoCodeRepositoryPersistence;

    private FestivalId $festivalId;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();

        /** @var OrderRepositoryPersistence $orderRepositoryPersistence */
        $orderRepositoryPersistence = $kernel->getContainer()->get(EsOrderRepositoryPersistence::class);
        $this->orderRepositoryPersistence = $orderRepositoryPersistence;

        /** @var EsArrangementFeeRepositoryPersistence $arrangementFeeRepositoryPersistence */
        $arrangementFeeRepositoryPersistence = $kernel->getContainer()->get(EsArrangementFeeRepositoryPersistence::class);
        $this->arrangementFeeRepositoryPersistence = $arrangementFeeRepositoryPersistence;

        /** @var EsPromoCodeRepositoryPersistence $promoCodeRepositoryPersistence */
        $promoCodeRepositoryPersistence = $kernel->getContainer()->get(EsPromoCodeRepositoryPersistence::class);
        $this->promoCodeRepositoryPersistence = $promoCodeRepositoryPersistence;

    }

    public function testCreateArrangementFee(): ArrangementFee
    {
        $kernel = self::bootKernel();
        /** @var AddArrangementFeeCommandHandler $handler */
        $handler = $kernel->getContainer()->get(AddArrangementFeeCommandHandler::class);
        $handlerResponse = $handler(new AddArrangementFeeCommand(
            'test',
            TestConstant::FESTIVAL_ID,
            1000
        ));
        $resultPersistence = $this->arrangementFeeRepositoryPersistence->ofId(ArrangementId::fromString($handlerResponse->id));
        $id = ArrangementId::fromString($handlerResponse->id);
        self::assertTrue($id->equals(ArrangementId::fromString($resultPersistence->id()->value())));

        return $resultPersistence;
    }

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     */
    public function testCreatePromoCode(): PromoCode
    {
        $kernel = self::bootKernel();
        /** @var AddPromoCodeCommandHandler $handler */
        $handler = $kernel->getContainer()->get(AddPromoCodeCommandHandler::class);
        $handlerResponse = $handler(new AddPromoCodeCommand(
            'test',
            100,
            TestConstant::FESTIVAL_ID,
            '%',
            100,
        ));
        $resultPersistence = $this->promoCodeRepositoryPersistence->ofId(PromoCodeId::fromString($handlerResponse->id));
        $id = PromoCodeId::fromString($handlerResponse->id);

        self::assertTrue($id->equals(PromoCodeId::fromString($resultPersistence->id()->value())));

        /** @var ProjectorConsumer $consumer */
        $consumer = $kernel->getContainer()->get(ProjectorConsumer::class);
        $consumer->consume();

        return $resultPersistence;
    }


    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     */
    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        /** @var  OrderCreateCommandHandler $handler */
        $handler = $kernel->getContainer()->get(OrderCreateCommandHandler::class);

        $arrangementFee =  $this->testCreateArrangementFee();
        $promoCode = $this->testCreatePromoCode();


        $orderResponse = $handler(new OrderCreateCommand(
            ['test1','test2'],
            UserId::random()->value(),
            $arrangementFee->id()->value(),
            TestConstant::FESTIVAL_ID,
            $promoCode->getTitle()->value(),
        ));

        $orderId = OrderId::fromString($orderResponse->orderId);
        $order = $this->orderRepositoryPersistence->ofId(OrderId::fromString($orderResponse->orderId));
        self::assertTrue($orderId->equals(OrderId::fromString($order->id()->value())));
    }
}