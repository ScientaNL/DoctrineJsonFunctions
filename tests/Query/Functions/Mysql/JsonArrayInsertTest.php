<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonArrayInsertTest extends MysqlTestCase
{
    public function testJsonArrayInsert()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY_INSERT('[\"a\", {\"b\": [1, 2]}, [3, 4]]', '$[1]', 1 + 8) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY_INSERT('[\"a\", {\"b\": [1, 2]}, [3, 4]]', '$[1]', 1 + 8) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_ARRAY_INSERT(j.jsonData, '$[0]', 1) IS NOT NULL",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_ARRAY_INSERT(j0_.jsonData, '$[0]', 1) IS NOT NULL"
        );
    }
}
