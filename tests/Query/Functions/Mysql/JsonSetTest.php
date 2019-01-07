<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonSetTest extends MysqlTestCase
{
    public function testJsonSet()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_SET('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 1 + 8, '$.c', '[true, false]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_SET('{ \"a\": 1, \"b\": [2, 3]}', '$.a', 1 + 8, '$.c', '[true, false]') AS sclr_0 FROM Blank b0_"
        );
    }
}
