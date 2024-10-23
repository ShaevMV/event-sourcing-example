<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class Status extends Keyword
{
    abstract public function isCorrectNextStatus(Status $status): bool;
}
