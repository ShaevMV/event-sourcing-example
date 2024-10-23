<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class PriceList extends Json
{
    /**
     * @var array<int,int>
     */
    private array $priceList = [];

    public function __construct(
        int $price,
        int $timestamp,
    ) {
        $this->priceList[$timestamp] = $price;
    }

    public function getPriceList(): array
    {
        return $this->priceList;
    }

    public function addPrice(int $price, int $timestamp): void
    {
        $this->priceList[$timestamp] = $price;
    }

    public function jsonSerialize(): array
    {
        return $this->priceList;
    }
}
