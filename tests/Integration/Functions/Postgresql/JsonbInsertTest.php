<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbInsertTest extends PostgresqlIntegrationTestCase
{
    public function testInsertsValueAtPath(): void
    {
        $this->insertJsonData(['a' => [1, 2]], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_INSERT(j.jsonCol, '{a,0}', '99') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertContains(99, $decoded['a']);
        $this->assertCount(3, $decoded['a']);
    }
}
