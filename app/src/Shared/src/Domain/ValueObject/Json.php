<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use JsonSerializable;

abstract class Json implements JsonSerializable, ValueObject
{
}