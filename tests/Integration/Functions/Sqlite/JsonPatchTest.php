<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonPatchTest extends SqliteIntegrationTestCase
{
    public function testAppliesMergePatch(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_PATCH('{\"a\":1,\"b\":2}', '{\"b\":99,\"c\":3}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals(99, $decoded['b']);
        $this->assertEquals(3, $decoded['c']);
    }

    public function testNullValueRemovesKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_PATCH('{\"a\":1,\"b\":2}', '{\"b\":null}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertArrayNotHasKey('b', $decoded);
    }
}
