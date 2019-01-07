<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonLengthTest extends MysqlTestCase
{
    public function testJsonLength()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('[1, 2, {\"a\": 3}]') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_LENGTH('[1, 2, {\"a\": 3}]') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonLengthPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_LENGTH('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_LENGTH('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') AS sclr_0 FROM Blank b0_"
        );
    }
}
