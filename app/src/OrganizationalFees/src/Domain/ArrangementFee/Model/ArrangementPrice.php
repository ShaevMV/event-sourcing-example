<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\ArrangementFee\Model;

use Shared\Domain\ValueObject\Price;

class ArrangementPrice extends Price
{
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


    /**
     * @var array<string,integer>
     */
    protected array $priceList;


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
}