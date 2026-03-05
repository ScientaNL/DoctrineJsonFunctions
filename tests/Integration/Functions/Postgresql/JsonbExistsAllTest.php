<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbExistsAllTest extends PostgresqlIntegrationTestCase
{
    public function testAllKeysExist(): void
    {
        $this->insertJsonData(['a' => 1, 'b' => 2], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_EXISTS_ALL(j.jsonCol, '{a,b}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }

    public function testNotAllKeysExist(): void
    {
        $this->insertJsonData(['a' => 1], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_EXISTS_ALL(j.jsonCol, '{a,b}') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertFalse($result);
    }
}
