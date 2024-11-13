<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Message;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class WorkerProjectionHandler
{
    public function __invoke(WorkerProjectionMessage $message): void
    {

    }
}