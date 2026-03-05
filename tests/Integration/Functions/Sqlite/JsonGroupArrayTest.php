<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonGroupArrayTest extends SqliteIntegrationTestCase
{
    public function testAggregatesMultipleRowsIntoArray(): void
    {
        $this->insertJsonData([], ['score' => 10]);
        $this->insertJsonData([], ['score' => 20]);
        $this->insertJsonData([], ['score' => 30]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GROUP_ARRAY(JSON_EXTRACT(j.jsonData, '$.score')) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertIsString($result);
        $decoded = json_decode((string) $result, true);
        $this->assertIsArray($decoded);
        $this->assertCount(3, $decoded);
        $this->assertContains(10, $decoded);
        $this->assertContains(20, $decoded);
        $this->assertContains(30, $decoded);
    }
}
