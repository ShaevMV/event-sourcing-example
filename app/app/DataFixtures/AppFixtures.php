<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly Connection  $connection,

        private readonly UserFixture $userFixtures,

    )
    {
    }

    /**
     * @throws Exception
     * @throws \DateMalformedStringException
     */
    public function load(ObjectManager $manager): void
    {
        //$this->dropData();
        // $product = new Product();
        // $manager->persist($product);
        $this->connection->beginTransaction();

        $this->userFixtures->load($manager);

        $manager->flush();

        $this->connection->commit();
    }

    /**
     * @throws Exception
     */
    private function dropData(): void
    {
        $this->connection->executeQuery('TRUNCATE TABLE event_store;');
        $this->connection->executeQuery('TRUNCATE TABLE arrangement_fee;');
        $this->connection->executeQuery('TRUNCATE TABLE event_store_snapshot;');
        $this->connection->executeQuery('TRUNCATE TABLE order;');
        $this->connection->executeQuery('TRUNCATE TABLE promo_code;');
        $this->connection->executeQuery('TRUNCATE TABLE security_user;');
    }
}
