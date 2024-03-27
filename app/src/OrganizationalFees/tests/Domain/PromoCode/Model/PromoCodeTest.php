<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Domain\PromoCode\Model;

use OrganizationalFees\Domain\PromoCode\Event\PromoCodeWasCreating;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\Discount;
use OrganizationalFees\Domain\PromoCode\Model\Limit;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\PromoCodeSing;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use PHPUnit\Framework\TestCase;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Model\FestivalId;
use Shared\Domain\ValueObject\ValidateException;

class PromoCodeTest extends TestCase
{
    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException|DomainException
     */
    public function testCreate(): void
    {
        $promoCode = PromoCode::create(
            Title::fromString('test'),
            new Discount(100),
            FestivalId::random(),
            PromoCodeSing::fromString(PromoCodeSing::FIX),
            new Limit(2),
        );

        $events = $promoCode->pullEvents();
        $this->assertCount(1, $events);
        $eventCurrent = $events->current();
        $this->assertInstanceOf(PromoCodeWasCreating::class, $eventCurrent);
        $promoCode->applyPromoCode();
        $promoCode->applyPromoCode();
        $this->expectException(DomainException::class);
        $promoCode->applyPromoCode();

    }
}