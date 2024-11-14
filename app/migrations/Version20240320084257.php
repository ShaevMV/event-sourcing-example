<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320084257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблицы arrangement_fee';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.arrangement_fee
        (
            id uuid NOT NULL,
            name varchar(255) NOT NULL,
            festival_id uuid NOT NULL,
            price jsonb NOT NULL,
            created_at timestamp without time zone default NOW(),
            updated_at timestamp without time zone default NOW(),
            CONSTRAINT arrangement_fee_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);

    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.arrangement_fee');
    }
}
