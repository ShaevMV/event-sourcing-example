<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Domain\ArrangementFee\Model;

use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementFee;
use PHPUnit\Framework\TestCase;
use Shared\Domain\Model\FestivalId;

class ArrangementFeeTest extends TestCase
{
    public function testCreate(): ArrangementFee
    {
        $arrangementFee = ArrangementFee::create(
            'test',
            100,
            FestivalId::random(),
        );

        $events = $arrangementFee->pullEvents();
        $this->assertCount(1, $events);
        $eventCurrent = $events->current();
        $this->assertInstanceOf(ArrangementFeeWasCreating::class, $eventCurrent);
        $this->assertEquals(100, $arrangementFee->getPrice());

        return $arrangementFee;
    }

    public function testUpdatePrice(): void
    {
        $arrangementFee = $this->testCreate();
        $arrangementFee->updatePrice(150, time());
        $this->assertEquals(150, $arrangementFee->getPrice());

        $arrangementFee->updatePrice(250, time() + 10000);
        $this->assertEquals(150, $arrangementFee->getPrice());
    }
}
