<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonSetTest extends MysqlTestCase
{
    public function testJsonSet()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 1 + 8, '$.c', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 1 + 8, '$.c', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_SET(j.jsonData, '$.score', 0) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_SET(j0_.jsonData, '$.score', 0) IS NOT NULL"
        );
    }
}
