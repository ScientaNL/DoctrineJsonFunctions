<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonGroupObjectTest extends SqliteIntegrationTestCase
{
    public function testAggregatesRowsIntoObject(): void
    {
        $this->insertJsonData(['key' => 'a'], ['val' => 1]);
        $this->insertJsonData(['key' => 'b'], ['val' => 2]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GROUP_OBJECT(
                 JSON_EXTRACT(j.jsonCol, '$.key'),
                 JSON_EXTRACT(j.jsonData, '$.val')
             ) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertIsString($result);
        $decoded = json_decode((string) $result, true);
        $this->assertIsArray($decoded);
        $this->assertArrayHasKey('a', $decoded);
        $this->assertArrayHasKey('b', $decoded);
    }
}
