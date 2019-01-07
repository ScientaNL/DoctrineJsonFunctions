<?php

namespace Scienta\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Scienta\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonQuoteTest extends MysqlTestCase
{
    public function testJsonQuote()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_QUOTE('\"null\"') from Scienta\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_QUOTE('\"null\"') AS sclr_0 FROM Blank b0_"
        );
    }
}
