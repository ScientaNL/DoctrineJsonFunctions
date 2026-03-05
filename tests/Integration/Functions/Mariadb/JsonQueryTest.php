<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonQueryTest extends MariadbIntegrationTestCase
{
    public function testExtractsArrayAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_QUERY('{\"a\":[1,2,3]}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals([1, 2, 3], $decoded);
    }

    public function testReturnsNullForScalarPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_QUERY('{\"a\":1}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        // JSON_QUERY returns NULL for non-object/non-array values
        $this->assertNull($result);
    }
}
