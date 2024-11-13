<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class DateTimeImmutable implements \Stringable, ValueObject
{
    final public function __construct(protected \DateTimeImmutable $value)
    {
    }

    public static function current(): static
    {
        return new static(new \DateTimeImmutable());
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function equals(DateTimeImmutable $other): bool
    {
        return $this->value()->getTimestamp() === $other->value()->getTimestamp();
    }

    public function __toString(): string
    {
        return $this->value()->format(\DATE_RFC3339);
    }
}
