<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonRemoveTest extends SqliteIntegrationTestCase
{
    public function testRemovesKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_REMOVE('{\"a\":1,\"b\":2}', '$.b') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertArrayHasKey('a', $decoded);
        $this->assertArrayNotHasKey('b', $decoded);
    }

    public function testRemoveFromColumn(): void
    {
        $this->insertJsonData([], ['keep' => 1, 'drop' => 2]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_REMOVE(j.jsonData, '$.drop') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertArrayHasKey('keep', $decoded);
        $this->assertArrayNotHasKey('drop', $decoded);
    }
}
