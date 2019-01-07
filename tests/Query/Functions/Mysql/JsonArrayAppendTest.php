<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonArrayAppendTest extends MysqlTestCase
{
    public function testJsonArrayAppend()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAY_APPEND('[\"a\", [\"b\", \"c\"], \"d\"]', '$[1]', 1 + 8) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAY_APPEND('[\"a\", [\"b\", \"c\"], \"d\"]', '$[1]', 1 + 8) AS sclr_0 FROM Blank b0_"
        );
    }
}
