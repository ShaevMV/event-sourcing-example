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
        public readonly int $price,
        public readonly int $timestamp
    )
    {
        $this->priceList[$timestamp] = $price;
    }

    public function getLastPrice(): int
    {
        return end($this->priceList);
    }

    public function serialize(): ?string
    {
        return serialize($this->priceList);
    }

    public function unserialize(string $data)
    {
        $this->priceList = unserialize($data);
    }

    public function __serialize(): array
    {
        return $this->priceList;
    }

    public function __unserialize(array $data): void
    {
        $this->priceList = $data;
    }

    public function getPriceList(): array
    {
        return $this->priceList;
    }
}