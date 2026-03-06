<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mssql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MssqlIntegrationTestCase;

class JsonValueTest extends MssqlIntegrationTestCase
{
    public function testExtractsScalarValue(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":42}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('42', (string) $result);
    }

    public function testReturnsNullForMissingPath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE('{\"a\":1}', '$.missing') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertNull($result);
    }

    public function testExtractsFromEntityColumn(): void
    {
        $this->insertJsonData(['country' => 'NL'], ['score' => 9.5]);

        $result = $this->entityManager->createQuery(
            "SELECT JSON_VALUE(j.jsonData, '$.score') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertEquals('9.5', (string) $result);
    }

    public function testFilterByJsonValue(): void
    {
        $this->insertJsonData([], ['score' => 42]);
        $this->insertJsonData([], ['score' => 99]);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j
             WHERE JSON_VALUE(j.jsonData, '$.score') = '42'"
        )->getResult();

        $this->assertCount(1, $result);
    }
}
