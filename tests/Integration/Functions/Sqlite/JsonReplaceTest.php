<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonReplaceTest extends SqliteIntegrationTestCase
{
    public function testReplacesExistingValue(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_REPLACE('{\"a\":1,\"b\":2}', '$.b', 99) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals(99, $decoded['b']);
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
