<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonValueTest extends MysqlIntegrationTestCase
{
    public function testExtractsScalarValue(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":42}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('42', (string) $result);
    }

    public function testReturnsNullForMissingPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":1}', '$.missing') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertNull($result);
    }

    public function testReturningSimpleType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":\"hello\"}', '$.a', CHAR) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('hello', $result);
    }

    public function testReturningTypeWithParameters(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"price\":\"49.95\"}', '$.price', DECIMAL(10,2)) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('49.95', (string) $result);
    }

    public function testFilterByJsonValue(): void
    {
        $this->insertJsonData([], ['name' => 'Alice']);
        $this->insertJsonData([], ['name' => 'Bob']);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j
             WHERE JSON_VALUE(j.jsonData, '$.name') = 'Alice'"
        )->getResult();

        $this->assertCount(1, $result);
    }
}
