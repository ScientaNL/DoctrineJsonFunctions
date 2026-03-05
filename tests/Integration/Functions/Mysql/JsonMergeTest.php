<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonMergeTest extends MysqlIntegrationTestCase
{
    public function testMergesTwoObjects(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_MERGE('{\"a\":1}', '{\"b\":2}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals(2, $decoded['b']);
    }
}
