<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241023184451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Обновление типа у колонки price';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        alter table public.arrangement_fee
            alter column price type INT using price::INT;
SQL;
        $this->connection->executeStatement($sql);
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeStatement('alter table public.arrangement_fee type jsonb using price::jsonb;');
    }
}
