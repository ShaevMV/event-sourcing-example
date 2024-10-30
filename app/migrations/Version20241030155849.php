<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030155849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание таблице arrangement_fee_price';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS public.arrangement_fee_price
        (
            id uuid NOT NULL,
            arrangement_fee_id uuid NOT NULL,
            price integer NOT NULL,
            timestamp integer NOT NULL,
            created_at timestamp without time zone default NOW(),
            updated_at timestamp without time zone default NOW(),
            CONSTRAINT arrangement_fee_price_pkey PRIMARY KEY (id)
        )
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {


    }
}
