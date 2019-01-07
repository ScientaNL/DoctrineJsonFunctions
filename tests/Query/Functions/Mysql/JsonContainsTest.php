<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonContainsTest extends MysqlTestCase
{
    public function testJsonContains()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_CONTAINS('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', '1', '$.a') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_CONTAINS('{\"a\": 1, \"b\": 2, \"c\": {\"d\": 4}}', '1', '$.a') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonContainsWhere()
    {
        $this->assertDqlProducesSql(
            "SELECT j.jsonData FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_CONTAINS(j.jsonData, :value, '$.papers[*].quality') = 1",
            "SELECT j0_.jsonData AS jsonData_0 FROM JsonData j0_ WHERE JSON_CONTAINS(j0_.jsonData, ?, '$.papers[*].quality') = 1",
            ['value', 'foo']
        );
    }
}
