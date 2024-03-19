<?php

declare(strict_types=1);

namespace ArrangementFee\Domain\Order\Model;

use Shared\Domain\Aggregate\AggregateId;

interface OrderRepositoryPersistence
{

    public function ofId (AggregateId $userId):Order;
    public function persist(Order $order):void;
}