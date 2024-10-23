<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasUpdatePrice;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Model\FestivalId;

class ArrangementFee extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    protected readonly ArrangementPriceList $price;

    protected readonly ArrangementName $name;
    protected readonly FestivalId $festivalId;

    public static function create(
        string     $name,
        int        $price,
        FestivalId $festivalId,
    ): self
    {
        $arrangementFee = new self(ArrangementId::random());

        $arrangementFee->recordAndApply(new ArrangementFeeWasCreating(
            $arrangementFee->id()->value(),
            $name,
            $price,
            $festivalId->value()
        ));

        return $arrangementFee;
    }


    public function onArrangementFeeWasCreating(ArrangementFeeWasCreating $arrangementFeeWasCreating): void
    {
        $this->id = ArrangementId::fromString($arrangementFeeWasCreating->getAggregateId());
        $this->name = ArrangementName::fromString($arrangementFeeWasCreating->name);
        $this->price = new ArrangementPriceList(
            $arrangementFeeWasCreating->price,
            $arrangementFeeWasCreating->getOccurredOn()->getTimestamp()
        );
        $this->festivalId = FestivalId::fromString($arrangementFeeWasCreating->festivalId);
    }

    public function updatePrice(int $price, int $timestamp): self
    {
        $this->recordAndApply(new ArrangementFeeWasUpdatePrice(
            $this->id->value(),
            $price,
            $timestamp
        ));

        return $this;
    }

    public function onArrangementFeeWasUpdatePrice(ArrangementFeeWasUpdatePrice $arrangementFeeWasUpdatePrice): void
    {
        $this->price->addPrice(
            $arrangementFeeWasUpdatePrice->price,
            $arrangementFeeWasUpdatePrice->timestamp
        );
    }

    public function getPrice(?int $timestampNow = null): ?int
    {
        $timestampNow = null === $timestampNow ? time() : $timestampNow;
        $priceList = $this?->price->getPriceList() ?? [];
        foreach ($priceList as $timestamp => $price) {
            if ($timestamp <= $timestampNow) {
                return $price;
            }
        }

        return null;
    }
}