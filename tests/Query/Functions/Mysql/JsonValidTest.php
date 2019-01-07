<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonValidTest extends MysqlTestCase
{
    public function testJsonValid()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_VALID('{\"a\": 1}') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_VALID('{\"a\": 1}') AS sclr_0 FROM Blank b0_"
        );
    }
}
