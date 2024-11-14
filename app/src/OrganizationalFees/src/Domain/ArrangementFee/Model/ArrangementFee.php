<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasUpdatePrice;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ValueObject\ValidateException;

class ArrangementFee extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    protected readonly ArrangementPriceList $price;

    protected readonly ArrangementName $name;
    public readonly FestivalId $festivalId;

    public static function create(
        ArrangementName $name,
        ArrangementPrice $price,
        FestivalId $festivalId,
    ): self {
        $arrangementFee = new self(ArrangementId::random());

        $arrangementFee->recordAndApply(new ArrangementFeeWasCreating(
            $arrangementFee->id()->value(),
            $name->value(),
            $price->value(),
            $festivalId->value()
        ));

        return $arrangementFee;
    }

    /**
     * @throws ValidateException
     */
    public function onArrangementFeeWasCreating(ArrangementFeeWasCreating $arrangementFeeWasCreating): void
    {
        $this->id = ArrangementId::fromString($arrangementFeeWasCreating->getAggregateId());
        $this->name = ArrangementName::fromString($arrangementFeeWasCreating->name);
        $this->price = new ArrangementPriceList(
            new ArrangementPrice($arrangementFeeWasCreating->price),
            new ArrangementPriceTimestamp($arrangementFeeWasCreating->getOccurredOn()->getTimestamp())
        );
        $this->festivalId = FestivalId::fromString($arrangementFeeWasCreating->festivalId);
    }

    public function updatePrice(
        ArrangementPrice $price,
        ArrangementPriceTimestamp $timestamp,
    ): self {
        $this->recordAndApply(new ArrangementFeeWasUpdatePrice(
            $this->id->value(),
            $price->value(),
            $timestamp->value()
        ));

        return $this;
    }

    /**
     * @throws ValidateException
     */
    public function onArrangementFeeWasUpdatePrice(ArrangementFeeWasUpdatePrice $arrangementFeeWasUpdatePrice): void
    {
        $this->price->addPrice(
            new ArrangementPrice($arrangementFeeWasUpdatePrice->price),
            new ArrangementPriceTimestamp($arrangementFeeWasUpdatePrice->timestamp)
        );
    }

    public function getPrice(): ArrangementPriceList
    {
        return $this->price;
    }
}
