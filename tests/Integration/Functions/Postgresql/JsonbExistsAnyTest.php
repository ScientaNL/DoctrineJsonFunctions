<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbExistsAnyTest extends PostgresqlIntegrationTestCase
{
    public function testAnyKeyExists(): void
    {
        $this->insertJsonData(['a' => 1], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_EXISTS_ANY(j.jsonCol, '{a,b}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }

    public function testNoKeyExists(): void
    {
        $this->insertJsonData(['a' => 1], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_EXISTS_ANY(j.jsonCol, '{x,y}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertFalse($result);
    }
}
