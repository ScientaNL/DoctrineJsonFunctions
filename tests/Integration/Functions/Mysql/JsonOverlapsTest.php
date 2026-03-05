<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonOverlapsTest extends MysqlIntegrationTestCase
{
    public function testOverlappingArrays(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_OVERLAPS('[1,2,3]', '[3,4,5]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testNonOverlappingArrays(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_OVERLAPS('[1,2]', '[3,4]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }
}
