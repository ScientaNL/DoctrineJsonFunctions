<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonValidTest extends MysqlIntegrationTestCase
{
    public function testValidJsonReturnsOne(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALID('{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testInvalidJsonReturnsZero(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALID('not-json') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }
}
