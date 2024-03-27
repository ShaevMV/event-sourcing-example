<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use OrganizationalFees\Domain\ArrangementFee\Event\ArrangementFeeWasCreating;
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
        $this->price = new ArrangementPrice(
            $arrangementFeeWasCreating->price,
            $arrangementFeeWasCreating->getOccurredOn()->getTimestamp()
        );
        $this->festivalId = FestivalId::fromString($arrangementFeeWasCreating->festivalId);
    }

    public function getPrice(?int $timestampNow = null): ?int
    {
        $timestampNow = null === $timestampNow ? time() : $timestampNow;

        foreach ($this->price->getPriceList() as $timestamp => $price) {
            if ($timestamp <= $timestampNow) {
                return $price;
            }
        }

        return null;
    }
}