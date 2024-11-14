<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class PriceList extends Json
{
    /**
     * @var array<int,PositiveNumber>
     */
    protected array $priceList = [];

    public function __construct(
        PositiveNumber $price,
        Timestamp $timestamp,
    ) {
        $this->priceList[$timestamp->value()] = $price;
    }

    public function getPriceList(): array
    {
        return $this->priceList;
    }

    public function addPrice(PositiveNumber $price, Timestamp $timestamp): void
    {
        $this->priceList[$timestamp->value()] = $price;
    }

    public function jsonSerialize(): array
    {
        return $this->priceList;
    }
}
