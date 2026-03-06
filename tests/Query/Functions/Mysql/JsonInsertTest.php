<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonInsertTest extends MysqlTestCase
{
    public function testJsonInsert()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 10 - 4, '$.c', 8-3) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_INSERT('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 10 - 4, '$.c', 8 - 3) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_INSERT(j.jsonData, '$.x', 1) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_INSERT(j0_.jsonData, '$.x', 1) IS NOT NULL"
        );
    }
}
