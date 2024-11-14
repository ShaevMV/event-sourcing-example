<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Tests\PhpUnit;

use Shared\Infrastructure\Tests\Doctrine\DatabaseArrangerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

abstract class InfrastructureTestCase extends KernelTestCase
{
    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::databaseArranger()->beforeClass();
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        self::databaseArranger()->beforeTest();
    }

    /**
     * @throws \Exception
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        self::databaseArranger()->afterTest();
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        self::databaseArranger()->afterClass();
    }

    /**
     * @throws \Exception
     */
    public function get(string $class): ?object
    {
        self::bootKernel(['environment' => 'test']);

        return self::getContainer()->get($class);
    }

    /**
     * @throws \Exception
     */
    protected static function databaseArranger(): DatabaseArrangerInterface
    {
        self::bootKernel(['environment' => 'test']);

        /** @var DatabaseArrangerInterface $database */
        $database = self::getContainer()->get(DatabaseArrangerInterface::class);

        return $database;
    }
}
