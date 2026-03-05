<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonReplaceTest extends MysqlIntegrationTestCase
{
    public function testReplacesExistingKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_REPLACE('{\"a\":1}', '$.a', 99) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(99, $decoded['a']);
    }

    public function testDoesNotInsertMissingKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_REPLACE('{\"a\":1}', '$.z', 99) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertArrayNotHasKey('z', $decoded);
    }
}
