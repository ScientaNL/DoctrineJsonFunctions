<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonPrettyTest extends MysqlIntegrationTestCase
{
    public function testPrettyPrintsJson(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_PRETTY('{\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        // Pretty-printed output has newlines and indentation
        $this->assertStringContainsString("\n", (string) $result);
        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
    }
}
