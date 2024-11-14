<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319121922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы order';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.order
        (
            id uuid NOT NULL,
            user_id uuid NOT NULL,
            guest jsonb NOT NULL default '[]',
            arrangement_fee_id uuid NOT NULL,
            status varchar(255) default 'new',
            created_at timestamp without time zone default NOW(),
            updated_at timestamp without time zone default NOW(),
            CONSTRAINT order_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.order');
    }
}
