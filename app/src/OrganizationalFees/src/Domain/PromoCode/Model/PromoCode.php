<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\PromoCode\Model;

use OrganizationalFees\Domain\PromoCode\Event\PromoCodeWasApply;
use OrganizationalFees\Domain\PromoCode\Event\PromoCodeWasCreating;
use OrganizationalFees\Domain\PromoCode\Exception\PromoCodeExceedingTheLimitException;
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

    protected Counter $count;

    protected Discount $discount;

    protected Sing $promoCodeSing;

    protected FestivalId $festivalId;

    public static function create(
        Title $title,
        Discount $discord,
        FestivalId $festivalId,
        Sing $promoCodeSing,
        ?Limit $limit = null,
    ): self {
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
        $this->promoCodeSing = Sing::fromString($promoCodeWasCreating->sing);
        $this->count = new Counter(0);
    }

    public function applyPromoCode(): self
    {
        if (!$this->limit->includes($this->count->value())) {
            throw new PromoCodeExceedingTheLimitException($this->title->value());
        }
        $this->recordAndApply(new PromoCodeWasApply($this->id->value()));

        return $this;
    }

    public function onPromoCodeWasApply(PromoCodeWasApply $promoCodeWasApply): void
    {
        $this->count->addCount();
    }

    public function validateCountAchievedLimit(): void
    {
        if (null !== $this->limit && $this->limit->equals($this->count)) {
            throw new PromoCodeExceedingTheLimitException($this->title->value());
        }
    }

    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }
}
