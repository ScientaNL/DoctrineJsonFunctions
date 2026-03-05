<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonSetTest extends MysqlIntegrationTestCase
{
    public function testUpdatesExistingKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_SET('{\"a\":1}', '$.a', 99) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(99, $decoded['a']);
    }

    public function testInsertsNewKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_SET('{\"a\":1}', '$.b', 2) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals(2, $decoded['b']);
    }
}
