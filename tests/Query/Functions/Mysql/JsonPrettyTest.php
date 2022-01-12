<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonPrettyTest extends MysqlTestCase
{
    public function testJsonPretty()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_PRETTY('\"null\"') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_PRETTY('\"null\"') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonPrettyMore()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_PRETTY(CONCAT('[', '1,2,45,3', ']')) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_PRETTY(CONCAT('[', '1,2,45,3', ']')) AS sclr_0 FROM Blank b0_"
        );
    }
}
