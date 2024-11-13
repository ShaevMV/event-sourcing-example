<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Message;

use Shared\Domain\Bus\Event\Deserializer;
use Shared\Domain\Bus\Projection\Projection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

#[AsMessageHandler]
class WorkerProjectionHandler
{
    /**
     * @var array<string, Projection[]>
     */
    private array $projections = [];

    /**
     * @param Projection[] $projections
     */
    public function __construct(
        iterable $projections,
        protected readonly ClientInterface $client,
        protected readonly Deserializer $deserializer,
        protected readonly string $queueName = 'projection_event',
    ) {
        foreach ($projections as $projection) {
            foreach ($projection->listenTo() as $classEvent) {
                $this->projections[$classEvent][] = $projection;
            }
        }
    }

    public function __invoke(WorkerProjectionMessage $message): bool
    {
        try {
            $event = $this->deserializer->deserialize($message->getSerialize());
            if (false === isset($this->projections[get_class($event)])) {
                return false;
            }

            $projections = $this->projections[get_class($event)];

            foreach ($projections as $projection) {
                $projection->project($event);
            }
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}
