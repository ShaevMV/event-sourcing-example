<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Projection\Projector\RabbitMQ;

use Shared\Domain\Bus\Event\EventStream;
use Shared\Domain\Bus\Event\Serializer;
use Shared\Domain\Bus\Projection\Projector;
use Shared\Infrastructure\Symfony\Message\WorkerProjectionMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class ProjectorProducerRabbitMQ implements Projector
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        protected readonly Serializer $serializer,
    ) {
    }

    public function project(EventStream $eventStream): void
    {
        foreach ($eventStream as $event) {
            $dataSerialize = $this->serializer->serialize($event);
            $this->messageBus->dispatch(new WorkerProjectionMessage($dataSerialize));
        }
    }
}
