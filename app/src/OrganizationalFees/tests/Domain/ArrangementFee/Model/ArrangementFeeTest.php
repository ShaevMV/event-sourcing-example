<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Domain\ArrangementFee\Model;

use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementName;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementPrice;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementPriceTimestamp;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\ValidateException;
use Tests\OrganizationalFees\Constant\TestConstant;

class ArrangementFeeTest extends TestCase
{
    /**
     * @throws ValidateException
     */
    public function testCreate(): ArrangementFee
    {
        $arrangementFee = ArrangementFee::create(
            ArrangementName::fromString('test'),
            new ArrangementPrice(100),
            new FestivalId(TestConstant::FESTIVAL_ID),
        );

        $events = $arrangementFee->pullEvents();
        $this->assertCount(1, $events);
        $eventCurrent = $events->current();
        $this->assertInstanceOf(ArrangementFeeWasCreating::class, $eventCurrent);
        $this->assertEquals(100, $arrangementFee->getPrice()->getCorrectPrice()->value());

        return $arrangementFee;
    }

    /**
     * @throws ValidateException
     */
    public function testUpdatePrice(): void
    {
        $arrangementFee = $this->testCreate();
        $arrangementFee->updatePrice(
            new ArrangementPrice(150),
            new ArrangementPriceTimestamp(time())
        );
        $this->assertEquals(150, $arrangementFee->getPrice()->getCorrectPrice()->value());

        $arrangementFee->updatePrice(
            new ArrangementPrice(250),
            new ArrangementPriceTimestamp(time() + 10000)
        );
        $this->assertEquals(150, $arrangementFee->getPrice()->getCorrectPrice()->value());
    }
}
