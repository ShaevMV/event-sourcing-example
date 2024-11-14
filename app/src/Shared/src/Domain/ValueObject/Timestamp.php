<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Timestamp extends PositiveNumber
{
    private const MIN_TIMESTAMP = 1041379200;

    protected function ensureIsValidUuid(int $value): void
    {
        if ($value < self::MIN_TIMESTAMP) {
            throw new ValidateException(sprintf('Значение должно быть больше %s, but got %s', self::MIN_TIMESTAMP, $value));
        }
    }
}
