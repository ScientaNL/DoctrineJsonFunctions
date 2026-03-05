<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonLengthTest extends MysqlIntegrationTestCase
{
    public function testArrayLength(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_LENGTH('[1,2,3]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(3, (int) $result);
    }

    public function testObjectLength(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_LENGTH('{\"a\":1,\"b\":2}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(2, (int) $result);
    }

    public function testLengthAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_LENGTH('{\"a\":[1,2,3]}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(3, (int) $result);
    }
}
