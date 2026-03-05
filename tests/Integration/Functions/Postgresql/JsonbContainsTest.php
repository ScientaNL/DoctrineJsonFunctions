<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbContainsTest extends PostgresqlIntegrationTestCase
{
    public function testContainsSubset(): void
    {
        // jsonCol {"a":1,"b":2} @> jsonData {"a":1} → true
        $this->insertJsonData(['a' => 1, 'b' => 2], ['a' => 1]);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_CONTAINS(j.jsonCol, j.jsonData) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }

    public function testDoesNotContain(): void
    {
        // jsonCol {"a":1} @> jsonData {"b":2} → false
        $this->insertJsonData(['a' => 1], ['b' => 2]);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_CONTAINS(j.jsonCol, j.jsonData) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertFalse($result);
    }
}
