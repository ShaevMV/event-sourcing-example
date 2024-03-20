<?php

declare(strict_types=1);

namespace ArrangementFee\Domain\ArrangementFee\Model;

use ArrangementFee\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class ArrangementFee extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    private readonly ArrangementPrice $price;

    private readonly ArrangementName $name;

    private readonly FestivalId $festivalId;

    public static function create(
        string            $name,
        int               $price,
        FestivalId        $festivalId,
    ): self
    {
        $arrangementFee = new self(ArrangementTypeId::random());

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
        $this->id = ArrangementTypeId::fromString($arrangementFeeWasCreating->getAggregateId());
        $this->name = ArrangementName::fromString($arrangementFeeWasCreating->name);
        $this->price = new ArrangementPrice($arrangementFeeWasCreating->price);
        $this->festivalId = FestivalId::fromString($arrangementFeeWasCreating->festivalId);
    }
}