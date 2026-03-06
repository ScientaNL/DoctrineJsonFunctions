<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Doctrine\DBAL\Exception as DBALException;
use Doctrine\ORM\Configuration;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonbContains;
use Scienta\DoctrineJsonFunctions\Tests\Integration\IntegrationTestCase;

/**
 * Validates issue #77: when the database column is json (not jsonb), the @> operator
 * fails with "operator does not exist: json @> unknown". This is a column configuration
 * problem, not a library defect. The fix is to ALTER the column to jsonb.
 *
 * The JSONB_CONTAINS function correctly generates left @> right SQL.
 * The error users see (operator does not exist: json @> unknown) happens because their database column is of type json instead of jsonb
 * PostgreSQL's @> operator only works on jsonb operands.
 *
 * What users need to do:
 * 1. Declare the entity column with options: ['jsonb' => true]
 * 2. Run a manual migration: ALTER TABLE t ALTER COLUMN col TYPE jsonb USING col::jsonb
 * 3. Ensure parameters are valid JSON (e.g. '"ROLE_ADMIN"' not 'ROLE_ADMIN')
 *
 * @see https://github.com/ScientaNL/DoctrineJsonFunctions/issues/77
 */
class JsonbContainsWithJsonColumnTest extends IntegrationTestCase
{
    protected static function getConnectionUrl(): ?string
    {
        return ($_ENV['POSTGRES_URL'] ?? getenv('POSTGRES_URL')) ?: null;
    }

    protected static function loadDqlFunctions(Configuration $config): void
    {
        $config->addCustomStringFunction(JsonbContains::FUNCTION_NAME, JsonbContains::class);
    }

    /**
     * Columns are left as json type (no ALTER TABLE to jsonb).
     * PostgreSQL cannot resolve @> on json operands, so a DBAL exception is thrown.
     * Users must ALTER their columns to jsonb to use JSONB operators.
     */
    public function testJsonColumnCausesErrorWithContainmentOperator(): void
    {
        $this->insertJsonData(['a' => 1, 'b' => 2], ['a' => 1]);

        $this->expectException(DBALException::class);

        $this->entityManager->createQuery(
            "SELECT JSONB_CONTAINS(j.jsonCol, j.jsonData) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();
    }
}
