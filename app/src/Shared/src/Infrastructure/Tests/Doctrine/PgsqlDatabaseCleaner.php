<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Tests\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

final class PgsqlDatabaseCleaner implements DatabaseCleaner
{
    private const TABLE_MIGRATION = 'doctrine_migration_versions';

    /**
     * @throws Exception
     */
    public function clear(EntityManagerInterface $entityManager): void
    {
        $connection = $entityManager->getConnection();

        $tables = $this->tables($connection);
        $truncateTablesSql = $this->truncateDatabaseSql($tables);
        $connection->executeStatement($truncateTablesSql);
    }

    private function truncateDatabaseSql(array $tables): string
    {
        $truncateTables = array_map(
            fn (array $table): string => sprintf('TRUNCATE TABLE public.%s CASCADE;', $table['table_name']),
            $tables
        );

        return sprintf(
            "SET session_replication_role = 'replica'; %s SET session_replication_role = 'origin';",
            implode(' ', $truncateTables)
        );
    }

    /**
     * @throws Exception
     */
    private function tables(Connection $connection): array
    {
        return $connection->executeQuery(
            "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' and table_name <> '".self::TABLE_MIGRATION."';"
        )->fetchAllAssociative();
    }
}
