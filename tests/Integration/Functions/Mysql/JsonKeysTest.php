<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonKeysTest extends MysqlIntegrationTestCase
{
    public function testReturnsTopLevelKeys(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_KEYS('{\"a\":1,\"b\":2}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        sort($decoded);
        $this->assertEquals(['a', 'b'], $decoded);
    }

    public function testReturnsKeysAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_KEYS('{\"a\":{\"x\":1,\"y\":2}}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        sort($decoded);
        $this->assertEquals(['x', 'y'], $decoded);
    }
}
