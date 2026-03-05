<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonObjectAggTest extends MysqlIntegrationTestCase
{
    public function testAggregatesRowsIntoObject(): void
    {
        $this->insertJsonData([], ['key' => 'a', 'value' => 1]);
        $this->insertJsonData([], ['key' => 'b', 'value' => 2]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_OBJECTAGG(
                JSON_UNQUOTE(JSON_EXTRACT(j.jsonData, '$.key')),
                JSON_EXTRACT(j.jsonData, '$.value')
             ) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertIsArray($decoded);
        $this->assertCount(2, $decoded);
    }
}
