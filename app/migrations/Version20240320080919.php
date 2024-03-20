<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320080919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        ALTER TABLE public.order 
            ADD COLUMN discount integer DEFAULT 0,
            ADD COLUMN price integer,
            ADD promo_code varchar DEFAULT '',
            ADD festival_id uuid;
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
        ALTER TABLE public.order 
            DROP COLUMN discount, price, promo_code, festival_id;
SQL;
        $this->connection->executeStatement($sql);
    }
}
