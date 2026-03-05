<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonTest extends SqliteIntegrationTestCase
{
    public function testMinifiesJson(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON('{ \"a\" : 1 , \"b\" : 2 }') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('{"a":1,"b":2}', $result);
    }

    public function testPassthroughValidJson(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON('[1,2,3]') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('[1,2,3]', $result);
    }
}
