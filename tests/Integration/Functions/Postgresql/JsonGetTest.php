<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonGetTest extends PostgresqlIntegrationTestCase
{
    public function testGetByKey(): void
    {
        $this->insertJsonData([], ['score' => 42]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GET(j.jsonData, 'score') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j"
        )->getSingleScalarResult();

        $this->assertEquals(42, (int) $result);
    }

    public function testGetReturnsNullForMissingKey(): void
    {
        $this->insertJsonData([], ['a' => 1]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GET(j.jsonData, 'missing') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j"
        )->getSingleScalarResult();

        $this->assertNull($result);
    }
}
