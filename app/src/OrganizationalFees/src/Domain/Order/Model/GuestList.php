<?php

declare(strict_types=1);

namespace OrganizationalFees\Domain\Order\Model;

use Shared\Domain\ValueObject\Json;

class GuestList extends Json
{
    /**
     * @param GuestName[] $guestName
     */
    public function __construct(
        protected array $guestName,
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->guestName;
    }

    public function getGuestName(): array
    {
        return $this->guestName;
    }

    public function toArray(): array
    {
        return array_map(fn (GuestName $guestName) => $guestName->value(), $this->guestName);
    }

    public function toCount(): int
    {
        return count($this->guestName);
    }

    /**
     * @param string[] $data
     */
    public static function fromArray(array $data): GuestList
    {
        $guestList = array_map(fn (string $guestName) => GuestName::fromString($guestName), $data);

        return new self($guestList);
    }
}
