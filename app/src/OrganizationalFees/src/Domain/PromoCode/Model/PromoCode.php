<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Model;

use OrganizationalFees\Domain\PromoCode\Event\PromoCodeWasCreating;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeSingDontCorrectException;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Model\FestivalId;
use Shared\Domain\ValueObject\ValidateException;

class PromoCode extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    protected readonly Title $title;

    protected ?Limit $limit = null;

    protected int $count = 0;

    protected Discount $discount;

    protected PromoCodeSing $promoCodeSing;

    protected FestivalId $festivalId;

    public static function create(
        Title     $title,
        Discount   $discord,
        FestivalId $festivalId,
        PromoCodeSing $promoCodeSing,
        ?Limit     $limit = null,
    ): self
    {
        $promoCode = new self(PromoCodeId::random());
        $promoCode->recordAndApply(new PromoCodeWasCreating(
            $promoCode->id->value(),
            $title->value(),
            $discord->value(),
            $festivalId->value(),
            $promoCodeSing->value(),
            $limit?->value(),
        ));

        return $promoCode;
    }

    /**
     * @throws ValidateException
     * @throws PromoCodeSingDontCorrectException
     */
    public function onPromoCodeWasCreating(PromoCodeWasCreating $promoCodeWasCreating): void
    {
        $this->festivalId = FestivalId::fromString($promoCodeWasCreating->festivalId);
        $this->discount = new Discount($promoCodeWasCreating->discount);
        $this->title = new Title($promoCodeWasCreating->title);
        $this->limit = null === $promoCodeWasCreating->limit ? null : new Limit($promoCodeWasCreating->limit);
        $this->promoCodeSing = PromoCodeSing::fromString($promoCodeWasCreating->promoCodeSing);
    }
}