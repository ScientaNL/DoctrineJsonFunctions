<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Sqlite;

use Scienta\DoctrineJsonFunctions\Tests\Integration\SqliteIntegrationTestCase;

class JsonQuoteTest extends SqliteIntegrationTestCase
{
    public function testQuotesString(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_QUOTE('hello') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('"hello"', $result);
    }

    public function testQuotesStringWithSpecialChars(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_QUOTE('say \"hi\"') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertIsString($result);
        $this->assertStringStartsWith('"', $result);
        $this->assertStringEndsWith('"', $result);
    }
}
