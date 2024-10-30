<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Tests\Doctrine;

use App\DataFixtures\AppFixtures;
use App\Kernel;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseArranger implements DatabaseArrangerInterface
{
    private DatabaseCleaner $cleaner;
    private Kernel $kernel;
    private EntityManagerInterface $entityManager;
    private AppFixtures $fixtures;

    public function __construct(
        Kernel $kernel,
        DatabaseCleaner $cleaner,
        AppFixtures $fixtures,
        EntityManagerInterface $entityManager,
    ) {
        $this->cleaner = $cleaner;
        $this->kernel = $kernel;
        $this->entityManager = $entityManager;
        $this->fixtures = $fixtures;
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
        $this->fixtures->load($this->entityManager);
    }

    /**
     * @throws Exception
     */
    public function afterTest(): void
    {
        $this->cleaner->clear($this->entityManager);
    }
}
