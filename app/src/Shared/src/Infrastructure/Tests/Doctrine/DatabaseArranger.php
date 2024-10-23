<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Tests\Doctrine;

use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseArranger implements DatabaseArrangerInterface
{
    private DatabaseCleaner $cleaner;
    private Kernel $kernel;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Kernel $kernel,
        DatabaseCleaner $cleaner,
        EntityManagerInterface $entityManager,
    ) {
        $this->cleaner = $cleaner;
        $this->kernel = $kernel;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function beforeClass(): void
    {
    }

    public function afterClass(): void
    {
    }

    public function beforeTest(): void
    {
        $this->cleaner->clear($this->entityManager);
    }

    public function afterTest(): void
    {
        $this->cleaner->clear($this->entityManager);
    }
}
