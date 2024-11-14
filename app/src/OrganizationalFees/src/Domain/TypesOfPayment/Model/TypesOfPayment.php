<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\TypesOfPayment\Model;

use OrganizationalFees\Domain\ArrangementFee\Model\ArrangementId;
use OrganizationalFees\Domain\Festival\Model\FestivalId;
use Shared\Domain\Aggregate\Aggregate;
use Shared\Domain\Aggregate\AggregateEventable;
use Shared\Domain\Aggregate\AggregateReconstructable;
use Shared\Domain\Aggregate\AggregateRoot;

class TypesOfPayment extends AggregateRoot implements Aggregate, AggregateEventable, AggregateReconstructable
{
    protected TypesOfPaymentName $name;
    protected TypesOfPaymentActive $active;
    protected TypesOfPaymentSort $sort;
    protected FestivalId $festivalId;

    public static function create(
        TypesOfPaymentName $name,
        TypesOfPaymentActive $active,
        TypesOfPaymentSort $sort,
        FestivalId $festivalId,
    ): self {
        $typesOfPayment = new self(ArrangementId::random());
    }
}
