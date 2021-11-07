<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

class JsonOverlapsTest extends MysqlTestCase
{
    public function testJsonOverlapsArray()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OVERLAPS('[\"bar\", 2]', '[2,5]') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OVERLAPS('[\"bar\", 2]', '[2,5]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonOverlapsObject()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OVERLAPS('{\"a\":1, \"b\":10}', '{\"c\":1,\"b\":10}') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OVERLAPS('{\"a\":1, \"b\":10}', '{\"c\":1,\"b\":10}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonOverlapsSingle()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_OVERLAPS('[\"foo\", 2, 18]', '2') FROM Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_OVERLAPS('[\"foo\", 2, 18]', '2') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonTestWhere()
    {
        $this->assertDqlProducesSql(
            "SELECT d.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData d WHERE JSON_OVERLAPS(d.jsonData, '[2,6,8]') = 1",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_OVERLAPS(j0_.jsonData, '[2,6,8]') = 1"
        );
    }
}
