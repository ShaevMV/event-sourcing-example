<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114134609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы types_of_payment';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.types_of_payment
        (
            id uuid NOT NULL,
            festival_id uuid NOT NULL,
            name varchar(255) NOT NULL,
            active boolean default true NOT NULL,
            sort int NOT NULL,
            created_at timestamp without time zone default NOW(),
            updated_at timestamp without time zone default NOW(),
            CONSTRAINT types_of_payment_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);

    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.types_of_payment');
    }
}
