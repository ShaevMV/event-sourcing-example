<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public const USER_EMAIL = 'user@user.ru';
    public const USER_ID = 'd3dc6743-ff75-4c72-af02-b25c9871e056';

    public function __construct(
        private readonly Connection $connection,
    )
    {
    }


    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $this->connection->insert(
            'security_user',
            [
                'id' => self::USER_ID,
                'username' => self::USER_EMAIL,
                'password_hash' => md5(self::USER_EMAIL),
            ]
        );

        $manager->flush();
    }
}