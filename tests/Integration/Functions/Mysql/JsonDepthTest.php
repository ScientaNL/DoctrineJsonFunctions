<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonDepthTest extends MysqlIntegrationTestCase
{
    public function testScalarDepth(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_DEPTH('1') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testNestedObjectDepth(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_DEPTH('{\"a\":{\"b\":1}}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(3, (int) $result);
    }
}
