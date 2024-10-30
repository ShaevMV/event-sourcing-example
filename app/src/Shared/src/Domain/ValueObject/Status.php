<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class Status extends Keyword
{
    public const APPROVED = 'approved';
    public const NEW = 'new';
    public const CANCEL = 'cancel';

    /**
     * @throws \Exception
     */
    public function isCorrectNextStatus(Status $status): bool
    {
        return match ($this->value()) {
            self::NEW => self::APPROVED === $status->value(),
            self::APPROVED => self::CANCEL === $status->value(),
            default => throw new \Exception('Unexpected match value'),
        };
    }
}
