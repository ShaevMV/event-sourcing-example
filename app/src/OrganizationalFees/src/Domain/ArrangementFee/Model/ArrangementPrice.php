<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use Shared\Domain\ValueObject\Price;

class ArrangementPrice extends Price
{
    /**
     * @var array<string,integer>
     */
    private array $priceList;

    public function __construct(
        int $price,
        int $timestamp
    )
    {
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