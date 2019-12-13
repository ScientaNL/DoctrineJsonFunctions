<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Postgresql;

use Scienta\DoctrineJsonFunctions\Tests\Query\PostgresqlTestCase;

class JsonbGetTextTest extends PostgresqlTestCase
{
    public function testSelect()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_GET_TEXT(d.id, 2) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT j0_.id ->> 2 AS sclr_0 FROM JsonData j0_"
        );
        $this->assertDqlProducesSql(
            "SELECT JSON_GET_TEXT(d.id, 'b') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d",
            "SELECT j0_.id ->> 'b' AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testWhere()
    {
        $this->assertDqlProducesSql(
            "SELECT d.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d WHERE JSON_GET_TEXT(d.jsonCol, 0) = true",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE j0_.jsonCol ->> 0 = true"
        );
    }
}
