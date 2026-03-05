<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonGetPathTest extends PostgresqlIntegrationTestCase
{
    public function testGetNestedValueByPath(): void
    {
        $this->insertJsonData([], ['a' => ['b' => 42]]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GET_PATH(j.jsonData, '{a,b}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertEquals(42, (int) $result);
    }
}
