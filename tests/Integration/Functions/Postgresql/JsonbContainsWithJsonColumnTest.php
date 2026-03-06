<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Doctrine\DBAL\Exception as DBALException;
use Doctrine\ORM\Configuration;
use Override;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonbContains;
use Scienta\DoctrineJsonFunctions\Tests\Integration\IntegrationTestCase;

/**
 * Validates issue #77: when the database column is json (not jsonb),
 * the @> operator fails with "operator does not exist: json @> unknown".
 * This test explicitly uses the `tests/Entities/JsonData.php` entity that does not have jsonb columns.
 *
 * @see https://github.com/ScientaNL/DoctrineJsonFunctions/issues/77
 */
class JsonbContainsWithJsonColumnTest extends IntegrationTestCase
{
    #[Override]
    protected static function getConnectionUrl(): ?string
    {
        return ($_ENV['POSTGRES_URL'] ?? getenv('POSTGRES_URL')) ?: null;
    }

    #[Override]
    protected static function loadDqlFunctions(Configuration $config): void
    {
        $config->addCustomStringFunction(JsonbContains::FUNCTION_NAME, JsonbContains::class);
    }

    /**
     * Asserts that SchemaTool creates json (not jsonb) columns for the JsonData entity.
     * This confirms the precondition for the error test below: no ALTER TABLE is performed
     * in this test class, so the columns remain json type as Doctrine creates them.
     */
    public function testSchemaColumnsAreJsonType(): void
    {
        $rows = $this->entityManager->getConnection()->fetchAllAssociative(
            "SELECT column_name, udt_name
             FROM information_schema.columns
             WHERE table_name = 'jsondata' AND column_name IN ('jsoncol', 'jsondata')
             ORDER BY column_name"
        );

        $types = array_column($rows, 'udt_name', 'column_name');
        $this->assertSame('json', $types['jsoncol'], 'jsoncol must be json type (not jsonb)');
        $this->assertSame('json', $types['jsondata'], 'jsondata must be json type (not jsonb)');
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

    /**
     * Proves that running the ALTER TABLE migration (the fix from issue #77) converts
     * the columns to jsonb and makes JSONB_CONTAINS work correctly.
     */
    public function testAlterColumnToJsonbFixesContainmentOperator(): void
    {
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement('ALTER TABLE jsondata ALTER COLUMN jsoncol TYPE jsonb USING jsoncol::jsonb');
        $conn->executeStatement('ALTER TABLE jsondata ALTER COLUMN jsondata TYPE jsonb USING jsondata::jsonb');

        $rows = $conn->fetchAllAssociative(
            "SELECT column_name, udt_name
             FROM information_schema.columns
             WHERE table_name = 'jsondata' AND column_name IN ('jsoncol', 'jsondata')
             ORDER BY column_name"
        );
        $types = array_column($rows, 'udt_name', 'column_name');
        $this->assertSame('jsonb', $types['jsoncol'], 'jsoncol must be jsonb after ALTER');
        $this->assertSame('jsonb', $types['jsondata'], 'jsondata must be jsonb after ALTER');

        $this->insertJsonData(['a' => 1, 'b' => 2], ['a' => 1]);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_CONTAINS(j.jsonCol, j.jsonData) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }
}
