<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonTypeTest extends MysqlIntegrationTestCase
{
    public function testObjectType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('OBJECT', $result);
    }

    public function testArrayType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('[1,2]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('ARRAY', $result);
    }

    public function testIntegerType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('42') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('INTEGER', $result);
    }
}
