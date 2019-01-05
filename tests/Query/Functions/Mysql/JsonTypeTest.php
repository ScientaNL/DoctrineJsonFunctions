<?php

namespace Syslogic\DoctrineJsonFunctions\Tests\Query\Functions\Mysql;

use Syslogic\DoctrineJsonFunctions\Tests\Query\MysqlTestCase;
use Doctrine\ORM\Query\Expr;

class JsonTypeTest extends MysqlTestCase
{
    public function testJsonType()
    {
        $this->assertDqlProducesSql(
            "SELECT JSON_DEPTH('{}') from Syslogic\DoctrineJsonFunctions\Tests\Entities\Blank b",
            "SELECT JSON_DEPTH('{}') AS sclr_0 FROM Blank b0_"
        );
    }
}
