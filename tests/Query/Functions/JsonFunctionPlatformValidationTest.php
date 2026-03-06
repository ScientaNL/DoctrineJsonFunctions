<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions;

use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Exception;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mariadb\JsonValue as MariadbJsonValue;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonDepth;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Mysql\JsonObject;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonbContains;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Postgresql\JsonGetText;
use Scienta\DoctrineJsonFunctions\Query\AST\Functions\Sqlite\JsonExtract;
use Scienta\DoctrineJsonFunctions\Tests\Mocks\ConnectionMock;
use Scienta\DoctrineJsonFunctions\Tests\Query\DbTestCase;

class JsonFunctionPlatformValidationTest extends DbTestCase
{
    public function testMysqlFunctionThrowsOnWrongPlatform(): void
    {
        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new PostgreSQLPlatform());
        $this->configuration->addCustomStringFunction(JsonDepth::FUNCTION_NAME, JsonDepth::class);

        $this->expectException(Exception::class);
        $this->produceSql(
            "SELECT JSON_DEPTH(j.jsonData) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j"
        );
    }

    public function testMariadbFunctionThrowsOnWrongPlatform(): void
    {
        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        // MySQLPlatform cannot be used here: on DBAL < 3.3 DBALCompatibility::mariaDBPlatform()
        // returns MySQLPlatform, so the instanceof check would pass and no exception would be thrown.
        $conn->setDatabasePlatform(new PostgreSQLPlatform());
        $this->configuration->addCustomStringFunction(MariadbJsonValue::FUNCTION_NAME, MariadbJsonValue::class);

        $this->expectException(Exception::class);
        $this->produceSql(
            "SELECT JSON_VALUE(j.jsonData, '$.a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j"
        );
    }

    public function testMysqlAndMariadbFunctionThrowsOnWrongPlatform(): void
    {
        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new PostgreSQLPlatform());
        $this->configuration->addCustomStringFunction(JsonObject::FUNCTION_NAME, JsonObject::class);

        $this->expectException(Exception::class);
        $this->produceSql(
            "SELECT JSON_OBJECT() FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b"
        );
    }

    public function testPostgresqlFunctionThrowsOnWrongPlatform(): void
    {
        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new MySQLPlatform());
        $this->configuration->addCustomStringFunction(JsonbContains::FUNCTION_NAME, JsonbContains::class);

        $this->expectException(Exception::class);
        $this->produceSql(
            "SELECT JSONB_CONTAINS(j.jsonData, '$.a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j"
        );
    }

    public function testPostgresqlOperatorFunctionThrowsOnWrongPlatform(): void
    {
        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new MySQLPlatform());
        $this->configuration->addCustomStringFunction(JsonGetText::FUNCTION_NAME, JsonGetText::class);

        $this->expectException(Exception::class);
        $this->produceSql(
            "SELECT JSON_GET_TEXT(j.jsonData, '$.a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j"
        );
    }

    public function testSqliteFunctionThrowsOnWrongPlatform(): void
    {
        /** @var ConnectionMock $conn */
        $conn = $this->entityManager->getConnection();
        $conn->setDatabasePlatform(new MySQLPlatform());
        $this->configuration->addCustomStringFunction(JsonExtract::FUNCTION_NAME, JsonExtract::class);

        $this->expectException(Exception::class);
        $this->produceSql(
            "SELECT JSON_EXTRACT(j.jsonData, '$.a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j"
        );
    }
}
