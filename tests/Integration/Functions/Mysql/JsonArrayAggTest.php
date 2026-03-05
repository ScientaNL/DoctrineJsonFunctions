<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonArrayAggTest extends MysqlIntegrationTestCase
{
    public function testAggregatesValuesIntoArray(): void
    {
        $this->insertJsonData([], ['val' => 1]);
        $this->insertJsonData([], ['val' => 2]);
        $this->insertJsonData([], ['val' => 3]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAYAGG(JSON_EXTRACT(j.jsonData, '$.val')) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertIsArray($decoded);
        $this->assertCount(3, $decoded);
    }
}
