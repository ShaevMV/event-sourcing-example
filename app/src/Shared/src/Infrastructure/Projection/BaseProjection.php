<?php

namespace Shared\Infrastructure\Projection;

use Doctrine\DBAL\Connection;

abstract class BaseProjection
{
    public function __construct(
        protected readonly Connection $connection,
    ) {
    }
}
