<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonRemoveTest extends MysqlIntegrationTestCase
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
}
