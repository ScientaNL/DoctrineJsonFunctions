<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbIsContainedTest extends PostgresqlIntegrationTestCase
{
    public function testIsContainedIn(): void
    {
        // jsonData {"a":1} <@ jsonCol {"a":1,"b":2} → true
        $this->insertJsonData(['a' => 1, 'b' => 2], ['a' => 1]);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_IS_CONTAINED(j.jsonData, j.jsonCol) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }
}
