<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Syslogic\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonExctractTest extends MysqlTestCase
{
    public function testJsonExtractSpace()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_EXTRACT('{ \"a b\": 10, \"b\": false}', '$.\"a b\"') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_EXTRACT('{ \"a b\": 10, \"b\": false}', '$.\"a b\"') AS sclr_0 FROM Blank b0_"
        );
    }
}