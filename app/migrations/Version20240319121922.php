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
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.arrangement_fee
        (
            id uuid NOT NULL,
            user_id character varying NOT NULL,
            guest jsonb NOT NULL default '[]',
            type_arrangement_id character varying NOT NULL,
            status varchar(255) default 'new',
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
