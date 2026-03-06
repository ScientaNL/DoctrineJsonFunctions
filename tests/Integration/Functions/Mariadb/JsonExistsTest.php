<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonExistsTest extends MariadbIntegrationTestCase
{
    public function testExistingPathReturnsOne(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_EXISTS('{\"a\":1}', '$.a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testMissingPathReturnsZero(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_EXISTS('{\"a\":1}', '$.b') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }

    public function testFilterByJsonExists(): void
    {
        $this->insertJsonData([], ['name' => 'Alice']);
        $this->insertJsonData([], ['score' => 10]);

        $result = $this->entityManager->createQuery(
            "SELECT j.id FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j
             WHERE JSON_EXISTS(j.jsonData, '$.name') = 1"
        )->getResult();

        $this->assertCount(1, $result);
    }
}
