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
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertEquals('Alice', $result);
    }
}
