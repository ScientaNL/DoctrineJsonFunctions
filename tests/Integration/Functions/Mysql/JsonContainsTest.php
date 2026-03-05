<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonContainsTest extends MysqlIntegrationTestCase
{
    public function testContainsValueAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_CONTAINS('{\"a\":1}', '1', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testDoesNotContainValueAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_CONTAINS('{\"a\":1}', '2', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }
}
