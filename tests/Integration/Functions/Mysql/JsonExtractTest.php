<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonExtractTest extends MysqlIntegrationTestCase
{
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

    public function testFilterByExtractedValue(): void
    {
        $this->insertJsonData([], ['score' => 42]);
        $this->insertJsonData([], ['score' => 99]);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j
             WHERE JSON_EXTRACT(j.jsonData, '$.score') = 42"
        )->getResult();

        $this->assertCount(1, $result);
    }
}
