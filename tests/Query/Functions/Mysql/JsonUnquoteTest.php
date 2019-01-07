<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonUnquoteTest extends MysqlTestCase
{
    public function testJsonUnquote()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_UNQUOTE('\"abc\"') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_UNQUOTE('\"abc\"') AS sclr_0 FROM Blank b0_"
        );
    }
}
