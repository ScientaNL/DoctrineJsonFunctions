<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonDetailedTest extends MariadbIntegrationTestCase
{
    public function testPrettyPrintsJson(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_DETAILED('{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertStringContainsString("\n", (string) $result);
        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
    }

    public function testPrettyPrintsJsonWithTabSize(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_DETAILED('{\"a\":1}', 4) AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertStringContainsString('    ', (string) $result);
        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
    }
}
