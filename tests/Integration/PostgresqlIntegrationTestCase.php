<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql as PgFunctions;
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
        // Register all 11 PostgreSQL functions (the unit-test PostgresqlTestCase only
        // registers 5; here we need them all for comprehensive integration testing).
        $config->addCustomStringFunction(PgFunctions\JsonbContains::FUNCTION_NAME, PgFunctions\JsonbContains::class);
        $config->addCustomStringFunction(PgFunctions\JsonbExists::FUNCTION_NAME, PgFunctions\JsonbExists::class);
        $config->addCustomStringFunction(PgFunctions\JsonbExistsAll::FUNCTION_NAME, PgFunctions\JsonbExistsAll::class);
        $config->addCustomStringFunction(PgFunctions\JsonbExistsAny::FUNCTION_NAME, PgFunctions\JsonbExistsAny::class);
        $config->addCustomStringFunction(PgFunctions\JsonbInsert::FUNCTION_NAME, PgFunctions\JsonbInsert::class);
        $config->addCustomStringFunction(PgFunctions\JsonbIsContained::FUNCTION_NAME, PgFunctions\JsonbIsContained::class);
        $config->addCustomStringFunction(PgFunctions\JsonExtractPath::FUNCTION_NAME, PgFunctions\JsonExtractPath::class);
        $config->addCustomStringFunction(PgFunctions\JsonGet::FUNCTION_NAME, PgFunctions\JsonGet::class);
        $config->addCustomStringFunction(PgFunctions\JsonGetPath::FUNCTION_NAME, PgFunctions\JsonGetPath::class);
        $config->addCustomStringFunction(PgFunctions\JsonGetPathText::FUNCTION_NAME, PgFunctions\JsonGetPathText::class);
        $config->addCustomStringFunction(PgFunctions\JsonGetText::FUNCTION_NAME, PgFunctions\JsonGetText::class);
    }
}
