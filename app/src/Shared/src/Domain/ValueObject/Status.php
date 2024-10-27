<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use PHPUnit\Util\Exception;

class Status extends Keyword
{
    public const PAID = 'paid';
    public const NEW = 'new';
    public const CANCEL = 'cancel';

    public function isCorrectNextStatus(Status $status): bool
    {
        return match ($status->value()) {
            self::NEW => self::PAID === $status->value(),
            self::PAID => self::CANCEL === $status->value(),
            default => throw new Exception('Unexpected match value'),
        };
    }
}
