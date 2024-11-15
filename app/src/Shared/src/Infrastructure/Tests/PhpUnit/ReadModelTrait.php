<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Tests\PhpUnit;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

trait ReadModelTrait
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    protected function getReadModel(string $table, string $id): array
    {
        /** @var Connection $connect */
        $connect = $this->get(Connection::class);
        $result = $connect->executeQuery("SELECT * FROM $table WHERE id = '$id'")->fetchAssociative();

        return false === $result ? [] : $result;
    }
}
