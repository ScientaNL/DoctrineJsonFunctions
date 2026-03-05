<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonMergePatchTest extends MysqlIntegrationTestCase
{
    public function testPatchOverwritesExistingKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_MERGE_PATCH('{\"a\":1,\"b\":2}', '{\"b\":99}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals(99, $decoded['b']);
    }

    public function testNullValueRemovesKey(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_MERGE_PATCH('{\"a\":1,\"b\":2}', '{\"b\":null}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertArrayNotHasKey('b', $decoded);
    }
}
