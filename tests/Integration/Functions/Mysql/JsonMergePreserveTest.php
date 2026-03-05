<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonMergePreserveTest extends MysqlIntegrationTestCase
{
    public function testPreservesDuplicateKeys(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_MERGE_PRESERVE('{\"a\":1}', '{\"a\":2}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals([1, 2], $decoded['a']);
    }
}
