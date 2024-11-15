<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

/**
 * @psalm-consistent-constructor
 */
abstract class Number implements \Stringable, ValueObject
{
    public function __construct(protected int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(Number $other): bool
    {
        return $this->value() === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public static function fromInt(int $value): self
    {
        return new static($value);
    }
}
