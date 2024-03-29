<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329203943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.promo_code
        (
            id uuid NOT NULL,
            title varchar(255) NOT NULL,
            festival_id uuid NOT NULL,
            discount integer NOT NULL,
            limit_count integer NULL,
            sing char NOT NULL,
            created_at timestamp without time zone default NOW(),
            updated_at timestamp without time zone default NOW(),
            CONSTRAINT promo_code_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);

    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.promo_code');
    }
}
