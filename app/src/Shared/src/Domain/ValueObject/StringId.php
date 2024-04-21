<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class StringId
{
    public function __construct(
        protected string $value
    )
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function equals(StringId $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
}