<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241024004451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблице festival';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.festival
        (
            id uuid NOT NULL,
            name varchar(255) NOT NULL,
            date_start timestamp without time zone NOT NULL,
            date_end timestamp without time zone NOT NULL,
            pdf_template text NOT NULL,
            mail_template text NOT NULL,
            created_at timestamp without time zone default NOW(),
            updated_at timestamp without time zone default NOW(),
            CONSTRAINT festival_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('DROP TABLE IF EXISTS public.festival');
    }
}
