<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Integration\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Integration\MariadbIntegrationTestCase;

class JsonLooseTest extends MariadbIntegrationTestCase
{
    public function testLooseJsonIsValid(): void
    {
        $result = $this->entityManager->createQuery(
            "SELECT JSON_LOOSE('{ \"a\" :  1 }') AS val
             FROM Scienta\\DoctrineJsonFunctions\\Tests\\Entities\\Blank b"
        )->getSingleScalarResult();

        $decoded = json_decode((string) $result, true);
        $this->assertEquals(1, $decoded['a']);
    }
}
