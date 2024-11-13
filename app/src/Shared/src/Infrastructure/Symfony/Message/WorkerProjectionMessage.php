<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Message;

class WorkerProjectionMessage
{
    public function __construct(
        private readonly string $serialize,
    )
    {
    }

    public function getSerialize(): string
    {
        return $this->serialize;
    }
}