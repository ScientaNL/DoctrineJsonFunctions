<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonGetPathTextTest extends PostgresqlIntegrationTestCase
{
    public function testGetNestedTextByPath(): void
    {
        $this->insertJsonData([], ['a' => ['b' => 'hello']]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_GET_PATH_TEXT(j.jsonData, '{a,b}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\PostgresqlEntities\\JsonbData j"
        )->getSingleScalarResult();

        $this->assertEquals('hello', $result);
    }
}
