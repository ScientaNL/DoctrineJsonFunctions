<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonValueTest extends MysqlIntegrationTestCase
{
    public function testExtractsScalarValue(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":42}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('42', (string) $result);
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
