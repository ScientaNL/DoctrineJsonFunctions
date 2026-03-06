<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonReplaceTest extends MysqlTestCase
{
    public function testJsonReplace()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 8 + 6) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REPLACE('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 8 + 6) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonReplaceMore()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_REPLACE('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 10, '$.c', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_REPLACE('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 10, '$.c', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_REPLACE(j.jsonData, '$.name', 'Bob') IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_REPLACE(j0_.jsonData, '$.name', 'Bob') IS NOT NULL"
        );
    }
}
