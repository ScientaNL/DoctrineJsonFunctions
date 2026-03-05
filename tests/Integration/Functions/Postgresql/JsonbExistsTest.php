<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\PostgresqlIntegrationTestCase;

class JsonbExistsTest extends PostgresqlIntegrationTestCase
{
    public function testKeyExists(): void
    {
        $this->insertJsonData(['a' => 1], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_EXISTS(j.jsonCol, 'a') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertTrue($result);
    }

    public function testKeyDoesNotExist(): void
    {
        $this->insertJsonData(['a' => 1], []);

        $result = $this->entityManager->createQuery(
            "SELECT JSONB_EXISTS(j.jsonCol, 'z') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\JsonData j"
        )->getSingleScalarResult();

        $this->assertFalse($result);
    }
}
