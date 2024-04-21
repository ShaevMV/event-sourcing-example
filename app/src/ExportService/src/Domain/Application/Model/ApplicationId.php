<?php

namespace ExportService\Domain\Application\Model;

use Shared\Domain\Aggregate\AggregateId;
use Shared\Domain\ValueObject\StringId;

final class ApplicationId extends StringId implements AggregateId
{

}