<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

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
}
