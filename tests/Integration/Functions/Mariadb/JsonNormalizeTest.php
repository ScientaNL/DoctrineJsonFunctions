<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonNormalizeTest extends MariadbIntegrationTestCase
{
    public function testNormalizesJson(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_NORMALIZE('{\"b\":2,\"a\":1}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals(2, $decoded['b']);
    }
}
