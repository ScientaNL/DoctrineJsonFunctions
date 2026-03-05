<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonContainsPathTest extends MysqlIntegrationTestCase
{
    public function testPathExists(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_CONTAINS_PATH('{\"a\":1}', 'one', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testPathDoesNotExist(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_CONTAINS_PATH('{\"a\":1}', 'one', '$.b') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }
}
