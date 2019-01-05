<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Syslogic\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonInsertTest extends MysqlTestCase
{
    public function testJsonInsert()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_INSERT('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 10 - 4, '$.c', 8-3) from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_INSERT('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 10 - 4, '$.c', 8 - 3) AS sclr_0 FROM Blank b0_"
        );
    }
}