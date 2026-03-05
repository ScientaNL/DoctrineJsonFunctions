<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonExtractTest extends SqliteIntegrationTestCase
{
    public function testExtractStringField(): void
    {
        $this->insertJsonData([], ['name' => 'Alice']);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_EXTRACT(j.jsonData, '$.name') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertEquals('Alice', $result);
    }

    public function testExtractNumericField(): void
    {
        $this->insertJsonData([], ['score' => 42]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_EXTRACT(j.jsonData, '$.score') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertEquals(42, (int) $result);
    }

    public function testExtractMissingFieldReturnsNull(): void
    {
        $this->insertJsonData([], ['name' => 'Bob']);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_EXTRACT(j.jsonData, '$.missing') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertNull($result);
    }
}
