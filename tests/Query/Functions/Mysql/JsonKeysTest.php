<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonKeysTest extends MysqlTestCase
{
    public function testJsonKeys()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}') AS sclr_0 FROM Blank b0_"
        );
    }

    public function testJsonKeysPath()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_KEYS('{\"a\": 1, \"b\": {\"c\": 30}}', '$.b') AS sclr_0 FROM Blank b0_"
        );
    }
}
