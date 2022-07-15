<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonGroupArrayTest extends MysqlTestCase
{
    public function testJsonArrayAgg()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_ARRAYAGG('a') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_ARRAYAGG('a') AS sclr_0 FROM Blank b0_"
        );
    }
}
