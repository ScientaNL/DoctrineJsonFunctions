<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonQuoteTest extends MysqlIntegrationTestCase
{
    public function testQuotesString(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_QUOTE('hello') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('"hello"', $result);
    }
}
