<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonSearchTest extends MysqlIntegrationTestCase
{
    public function testFindsValuePath(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_SEARCH('{\"a\":\"hello\"}', 'one', 'hello') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertEquals('$.a', json_decode((string) $result));
    }

    public function testReturnsNullWhenNotFound(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_SEARCH('{\"a\":\"hello\"}', 'one', 'world') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $this->assertNull($result);
    }
}
