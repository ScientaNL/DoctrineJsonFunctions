<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonValueTest extends MariadbIntegrationTestCase
{
    public function testExtractsScalarValue(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"name\":\"Alice\"}', '$.name') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('Alice', $result);
    }

    public function testReturnsNullForMissingPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":1}', '$.missing') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertNull($result);
    }
}
