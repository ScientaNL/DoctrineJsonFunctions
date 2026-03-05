<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MysqlIntegrationTestCase;

class JsonObjectTest extends MysqlIntegrationTestCase
{
    public function testBuildsObjectFromKeyValuePairs(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_OBJECT('a', 1, 'b', 'hello') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
        $this->assertEquals('hello', $decoded['b']);
    }
}
