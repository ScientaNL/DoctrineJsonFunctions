<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonEqualsTest extends MariadbIntegrationTestCase
{
    public function testEqualJsonReturnsOne(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_EQUALS('{\"a\":1}', '{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(1, (int) $result);
    }

    public function testUnequalJsonReturnsZero(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_EQUALS('{\"a\":1}', '{\"a\":2}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals(0, (int) $result);
    }
}
