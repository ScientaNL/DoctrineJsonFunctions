<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonTypeTest extends SqliteIntegrationTestCase
{
    public function testObjectType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('object', $result);
    }

    public function testArrayType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('[1,2]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('array', $result);
    }

    public function testIntegerType(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('42') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('integer', $result);
    }

    public function testTypeAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_TYPE('{\"name\":\"Alice\"}', '$.name') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('text', $result);
    }
}
