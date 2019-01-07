<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonDepthTest extends MysqlTestCase
{
    public function testJsonDepth()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DEPTH('{}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_DEPTH('{}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonDepthNested()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DEPTH('[10, {\"a\": 20}]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_DEPTH('[10, {\"a\": 20}]') AS sclr_0 FROM Blank b0_"
        );
    }
}
