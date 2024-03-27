<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class PositiveNumber extends Number
{
    /**
     * @throws ValidateException
     */
    public function __construct(int $value)
    {
        $this->ensureIsValidUuid($value);

        parent::__construct($value);
    }

    /**
     * @throws ValidateException
     */
    private function ensureIsValidUuid(int $value): void
    {
        if ($value < 0) {
            throw new ValidateException(sprintf('Значение должно быть положительным, but got %s', $value));
        }
    }
}
