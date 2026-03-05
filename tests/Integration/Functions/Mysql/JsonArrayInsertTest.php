<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonArrayInsertTest extends MysqlIntegrationTestCase
{
    public function testInsertsValueAtIndex(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAY_INSERT('[1,3]', '$[1]', 2) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals([1, 2, 3], json_decode((string) $result, true));
    }
}
