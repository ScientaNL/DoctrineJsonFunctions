<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration;

use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql as PgFunctions;

abstract class PostgresqlIntegrationTestCase extends IntegrationTestCase
{
    protected static function getConnectionUrl(): ?string
    {
        return $_ENV['POSTGRES_URL'] ?? getenv('POSTGRES_URL') ?: null;
    }

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->entityManager === null) {
            return;
        }

        // Doctrine maps JSON columns to `json` type; alter to `jsonb` so all
        // JSONB operators (@>, <@, ?, ?&, ?|) work in integration tests.
        // Doctrine creates unquoted table/column names → PostgreSQL stores them as lowercase.
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement(
            'ALTER TABLE jsondata ALTER COLUMN jsoncol TYPE jsonb USING jsoncol::jsonb'
        );
        $conn->executeStatement(
            'ALTER TABLE jsondata ALTER COLUMN jsondata TYPE jsonb USING jsondata::jsonb'
        );
    }

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
