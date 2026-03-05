<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonArrayTest extends MysqlIntegrationTestCase
{
    public function testBuildsArrayFromLiterals(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAY(1, 2, 3) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals([1, 2, 3], json_decode((string) $result, true));
    }

    public function testEmptyArray(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAY() AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals([], json_decode((string) $result, true));
    }
}
