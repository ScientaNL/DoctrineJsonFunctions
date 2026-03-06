<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonGetTextTest extends PostgresqlIntegrationTestCase
{
    public function testGetTextByKey(): void
    {
        $this->insertJsonData([], ['name' => 'Alice']);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GET_TEXT(j.jsonData, 'name') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j"
        )->getSingleScalarResult();

        $this->assertEquals('Alice', $result);
    }

    public function testFilterByGetText(): void
    {
        $this->insertJsonData([], ['name' => 'Alice']);
        $this->insertJsonData([], ['name' => 'Bob']);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j
             WHERE JSON_GET_TEXT(j.jsonData, 'name') = 'Alice'"
        )->getResult();

        $this->assertCount(1, $result);
    }
}
