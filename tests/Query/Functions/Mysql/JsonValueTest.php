<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonValueTest extends MysqlTestCase
{
    public function testJsonValueForData()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE(j.jsonData, '$.a', UNSIGNED) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j",
            "SELECT JSON_VALUE(j0_.jsonData, '$.a' RETURNING UNSIGNED) AS sclr_0 FROM JsonData j0_"
        );
    }

    public function testJsonValueReturningDecimal()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE('{\"item\": \"shoes\", \"price\": \"49.95\"}', '$.price', DECIMAL(4,2)) from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALUE('{\"item\": \"shoes\", \"price\": \"49.95\"}', '$.price' RETURNING DECIMAL(4,2)) AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonValueForDataReturningVarchar()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALUE(j.jsonData, '$.something', CHAR(255)) FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j",
            "SELECT JSON_VALUE(j0_.jsonData, '$.something' RETURNING CHAR(255)) AS sclr_0 FROM JsonData j0_"
        );
    }
}
