<?php

declare(strict_types=1);

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;

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

    public function testWhere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT j.id FROM Scienta\DoctrineJsonFunctions\Tests\Entities\JsonData j WHERE JSON_DEPTH(j.jsonData) = 1",
            "SELECT j0_.id AS id_0 FROM JsonData j0_ WHERE JSON_DEPTH(j0_.jsonData) = 1"
        );
    }
}
