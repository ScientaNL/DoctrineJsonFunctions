<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonArrayLengthTest extends SqliteIntegrationTestCase
{
    public function testReturnsLengthOfArray(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAY_LENGTH('[1,2,3]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(3, (int) $result);
    }

    public function testReturnsZeroForNonArray(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAY_LENGTH('{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }

    public function testReturnsLengthAtPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_ARRAY_LENGTH('{\"items\":[1,2,3,4]}', '$.items') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(4, (int) $result);
    }
}
