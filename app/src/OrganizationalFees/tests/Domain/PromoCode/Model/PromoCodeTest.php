<?php

declare(strict_types=1);

namespace Tests\OrganizationalFees\Domain\PromoCode\Model;

use OrganizationalFees\Domain\PromoCode\Event\PromoCodeWasCreating;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeExceedingTheLimitException;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use OrganizationalFees\Domain\PromoCode\Model\Discount;
use OrganizationalFees\Domain\PromoCode\Model\Limit;
use OrganizationalFees\Domain\PromoCode\Model\PromoCode;
use OrganizationalFees\Domain\PromoCode\Model\Sing;
use OrganizationalFees\Domain\PromoCode\Model\Title;
use PHPUnit\Framework\TestCase;
use Shared\Domain\Exception\DomainException;
use Shared\Domain\Model\FestivalId;
use Shared\Domain\ValueObject\ValidateException;
use Tests\OrganizationalFees\Constant\TestConstant;

class PromoCodeTest extends TestCase
{
    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException|DomainException
     */
    public function testCreateFixNotLimit(): PromoCode
    {
        $promoCode = PromoCode::create(
            Title::fromString('test'),
            new Discount(100),
            new FestivalId(TestConstant::FESTIVAL_ID),
            Sing::fromString(Sing::FIX),
            null,
        );

        $events = $promoCode->pullEvents();
        $this->assertCount(1, $events);
        $eventCurrent = $events->current();
        $this->assertInstanceOf(PromoCodeWasCreating::class, $eventCurrent);

        return $promoCode;
    }

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     */
    public function testCreateTwoLimit(): PromoCode
    {
        $promoCode = PromoCode::create(
            Title::fromString('test'),
            new Discount(100),
            new FestivalId(TestConstant::FESTIVAL_ID),
            Sing::fromString(Sing::FIX),
            new Limit(2),
        );

        $promoCodeTwoLimit = clone $promoCode;

        $promoCode->applyPromoCode();
        $promoCode->applyPromoCode();
        $this->expectException(PromoCodeExceedingTheLimitException::class);
        $promoCode->validateCountAchievedLimit();
        $this->expectException(DomainException::class);
        $promoCode->applyPromoCode();

        return $promoCodeTwoLimit;
    }
}
