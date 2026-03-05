<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonObjectTest extends SqliteIntegrationTestCase
{
    public function testBuildsObjectFromPairs(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_OBJECT('a', 1, 'b', 'hello') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals('hello', $decoded['b']);
    }
}
