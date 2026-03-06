<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mariadb;

use Scienta\DoctrineJsonFunctions\Tests\Query\MariadbTestCase;

class JsonEqualsTest extends MariadbTestCase
{
    public function testJsonEquals()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EQUALS('{\"key1\":123}', '{\"key1\":123}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_EQUALS('{\"key1\":123}', '{\"key1\":123}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_EQUALS(j.jsonData, j.jsonCol) = 1",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_EQUALS(j0_.jsonData, j0_.jsonCol) = 1"
        );
    }
}
