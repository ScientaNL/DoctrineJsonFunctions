<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Tests\Query\PostgresqlTestCase;
use Override;

abstract class PostgresqlIntegrationTestCase extends IntegrationTestCase
{
    #[Override]
    protected static function getConnectionUrl(): ?string
    {
        return ($_ENV['POSTGRES_URL'] ?? getenv('POSTGRES_URL')) ?: null;
    }

    /** @return string[] */
    #[Override]
    protected static function getEntityPaths(): array
    {
        return [
            __DIR__ . '/../Entities',
            __DIR__ . '/../PostgresqlEntities',
        ];
    }

    #[Override]
    protected function insertJsonData(mixed $jsonCol, mixed $jsonData): void
    {
        $encoded = json_encode($jsonCol);
        $encodedData = json_encode($jsonData);

        $this->entityManager->getConnection()->insert('JsonbData', [
            'id'       => uniqid('', true),
            'jsonCol'  => $encoded !== false ? $encoded : '{}',
            'jsonData' => $encodedData !== false ? $encodedData : '{}',
        ]);
    }

    #[Override]
    protected static function loadDqlFunctions(Configuration $config): void
    {
        PostgresqlTestCase::loadDqlFunctions($config);
    }
}
